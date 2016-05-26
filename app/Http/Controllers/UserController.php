<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Validator;

use App\Department as Department;
use App\User as User;
use App\Helpers\Helper as Helper;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
  * Defines the CRUD methods for the UserController
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class UserController extends Controller
{

    /**
      * Controller Constructor defines what middleware to apply
      */
    public function __construct()
    {
        // Auth required
        $this->middleware('auth');
        $this->middleware('adminAccess');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = Session::get('user');
      $allowed_departments = Session::get('allowed_departments');

      // Return all users assigned to departments that the requester can see
      $users = $this->GetAllowedUsers($user, $allowed_departments);

      $data = array(
        'allowed_departments' => $allowed_departments,
        'requestUser' => $user,
        'users' => $users
      );

      return view('pages/users', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // NOTE not used
      return Response('Not found', 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Get all request inputs
      $data = $request->all();

      // Validate
      $reponse = $this->create_validator($data);
      if (isset($reponse)) {
        return $reponse;
      }

      // Create user
      User::create([
          'username' => $data['username'],
          'password' => bcrypt($data['password']),
      ]);

      // Success
      return redirect()->route('dashboard.settings.users.index')
                       ->with('message', 'User created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id ID of the user to show
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      // Prevent access if not an ajax request
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      // Get selected user
      $user = User::find($id);
      if ($user == null)
        return array('error' => 'Error: User not found.');

      return array('user' => $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id ID of the user to edit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      // NOTE not used
      return Response('Not found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id ID of the user to update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get selected user
        $user = User::find($id);

        if ($user == null)
          return redirect()->route('dashboard.settings.users.index')
                           ->with('message', 'Error: User not found');

        // Get all request inputs
        $data = $request->all();
        array_push($data, ['the_old_password' => $user->password]);

        // Validate
        $reponse = $this->edit_validator($data);
        if (isset($reponse)) {
          return $reponse;
        }

        // Update
        User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('dashboard.settings.users.index')
                         ->with('message', 'User created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id ID of the user to destroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // Load selected user
      $requestUser = Session::get('user');

      if ($requestUser->is_super_user == false)
        abort(401, 'Unauthorized');

      // Load user
      $user = User::find($id);

      if ($user == null)
        return redirect()->route('dashboard.settings.users.index')
                         ->with('message', 'Error: User not found');

      // Delete
      $user->delete();

      return redirect()->route('dashboard.settings.users.index')
                       ->with('message', 'User deleted successfully');
    }

    /**
      * Filter users by criteria
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function filter(Request $request)
    {
      $allowed_departments = Session::get('allowed_departments');
      $user = Session::get('user');

      // Get input from request
      $btnFindUser = $request->input('btnFindUser');
      $btnFindAll = $request->input('btnFindAll');
      $username = $request->input('txtUsername');
      $departmentID = $request->input('drpDepartments');
      $users = null;

      $users = $this->GetAllowedUsers($user, $allowed_departments);

      // Check which action to perform
      if (isset($btnFindUser)) {

        $filtered = collect([]);

        // Filter all available users for
        if ($username != false) {
          $filtered = $users->filter(function($item) use ($username) {
            if (strpos($item->username, $username) !== false) { // Get rough match
              return true;
            }
          });
        }

        // Filter by department id
        if ($filtered->count() == 0) {
          $filtered = $users->filter(function($item) use ($departmentID) {
            if ($item->department_id == $departmentID) {
              return true;
            }
          });
        }

        $users = $filtered;

      } else if (isset($btnFindAll)) {

        $username = null;

      } else {
        abort(401, 'Un-authorised');
      }

      $data = array(
        'requestUser' => $user,
        'users' => $users,
        'username' => $username,
        'allowed_departments' => $allowed_departments
      );

      return view('pages/users', $data);
    }

    /**
      * Gets an array of all the allowed users the specified user is able
      * to access and modify because they're admin
      * @param User $user
      * @param array $allowed_departments
      * @return EloquentCollection
      */
    public function GetAllowedUsers($user, $allowed_departments) {
      // Check if super or admin
      if ($user->is_super_user) {
        return User::all(); // Return all users
      } else {

        $users = collect([]);
        // Get every user assigned to every department
        // this admin is responsible for
        foreach ($allowed_departments as $department) {
          $departmentUsers = $department->Users()->get();

          if ($departmentUsers->count() > 0) {
            $users = $users->merge($departmentUsers);
          }
        }
      }

      // Only return unqiue users
      return $users->unique('id');
    }

    /**
      * Validates input before creating a selected object
      * @param  array   $data array of fields to validate
      * @return \Illuminate\Http\Response response if validation fails
      */
    protected function create_validator(array $data) {

      $validator = Validator::make($data, [
        'username' => 'required|max:40|unique:user',
        'password' => 'required|confirmed|min:6|max:60',
      ]);

      // If validator fails get the errors and warn the user
      // this redirects to prevent further execution
      if ($validator->fails()) {
        $message = Helper::getValidationErrors($validator);

        return redirect()->route('dashboard.settings.users.index')
        ->with('message', $message);
      }

    }

    /**
      * Validates input before creating a selected object
      * @param  array   $data array of fields to validate
      * @return \Illuminate\Http\Response response if validation fails
      */
    protected function edit_validator(array $data) {

      $validator = Validator::make($data, [
        'username' => 'required|max:40|unique:user',
        'password' => 'confirmed|min:6|max:60',
      ]);

      // If validator fails get the errors and warn the user
      // this redirects to prevent further execution
      if ($validator->fails()) {
        $message = Helper::getValidationErrors($validator);

        return redirect()->route('dashboard.settings.users.index')
        ->with('message', $message);
      }

    }
}
