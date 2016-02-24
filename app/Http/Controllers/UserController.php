<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Department as Department;
use App\User as User;
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

      $users = $this->GetAllowedUsers($user, $allowed_departments);

      $data = array(
        'allowed_departments' => $allowed_departments,
        'user' => $user,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

      $user = User::find($id);
      if ($user == null)
        abort(404, 'Not found');

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id ID of the user to destroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      abort(401, 'Unauthorized');
    }

    /**
      * Processes input from the screen. Includes basic filtering options
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function process(Request $request)
    {
      $allowed_departments = Session::get('allowed_departments');
      $user = Session::get('user');

      // Get input from request
      $btnFindUser = $request->input('btnFindUser');
      $btnFindAll = $request->input('btnFindAll');
      $username = $request->input('txtUsername');
      $departmentID = $request->input('drpDepartments');
      $users = null;

      // Check which action to perform
      if (isset($btnFindUser)) {

        // Filter all available users for
        $users = $this->GetAllowedUsers($user, $allowed_departments);
        $users = $users->filter(function($item) use ($username) {
          if ($item->username == $username) { // TODO CHANGE TO LIKE
            return true;
          }

          return false;
        });

      } else if (isset($btnFindAll)) {

        $username = null;
        $users = $this->GetAllowedUsers($user, $allowed_departments);

      } else {
        abort(401, 'Un-authorised');
      }

      $data = array(
        'user' => $user,
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
      * Soft deletes a specified resource
      * @param int  $id ID of the user to soft delete
      * @return \Illuminate\Http\Response
      */
    public function toggleDeleted($id) {

      $user = User::find($id);

      if ($user == null)
        abort(404, 'Not found.');

      if ($user->deleted == 0) {
        $user->deleted = 1;
      } else {
        $user->deleted = 0;
      }

      $user->save();

      return redirect()->route('dashboard.settings.users.index');
    }
}
