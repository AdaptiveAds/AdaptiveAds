<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Department as Department;
use App\User as User;

/**
  * Defines the CRUD methods for the PrivilegeController
  * @author Josh Preece
  * @license MIT
  * @since 1.0
  */
class PrivilegeController extends Controller
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
      $allowed_departments = Session::get('allowed_departments');

      $data = array(
        'allowed_departments' => $allowed_departments,
      );

      return view('pages/privileges', $data);
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
      // NOTE not used
      return Response('Not found', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      // NOTE not used
      return Response('Not found', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // NOTE not used
      return Response('Not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // NOTE not used
      return Response('Not found', 404);
    }

    /**
      * Shows the privileges add more page to allow
      * the user to select users to assign to a selected department
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function addMode(Request $request)
    {

      $allowed_departments = Session::get('allowed_departments');
      $departmentID = $request->input('drpDepartments');

      if ($departmentID == null)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'Please select a department to work with');

      // Get selected department
      $department = Department::find($departmentID);

      if ($department == null)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'Error: Department not found');


      $depUsers = $department->Users()->get();
      $allUsers = User::all();

      $users = $allUsers->diff($depUsers);

      if ($users->count() == 0)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'No users to add');

      Session::put('departmentID', $departmentID);

      $data = array(
        'users' => $users,
        'allowed_departments' => $allowed_departments,
        'department' => $department
      );

      return view('pages/privileges_addMode', $data);
    }

    /**
      * Shows the privileges remove mode page to allow
      * the user to remove selected users from a selected department
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function removeMode(Request $request)
    {
      $allowed_departments = Session::get('allowed_departments');
      $departmentID = $request->input('drpDepartments');

      if ($departmentID == null)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'Please select a department to work with');

      // Load selected department
      $department = Department::find($departmentID);

      if ($department == null)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'Error: Department not found');

      // Get users associated with the department
      $users = $department->Users()->get();

      if ($users->count() == 0)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'No users to remove');

      Session::put('departmentID', $departmentID);

      $data = array(
        'users' => $users,
        'allowed_departments' => $allowed_departments,
        'department' => $department
      );

      return view('pages/privileges_removeMode', $data);
    }

    /**
      * Adds selected users to a selected department
      * @param \Illuminate\Http\Request $request
      * @return array   Contains redirect url to process after request
      */
    public function addUser(Request $request)
    {
      if (Session::has('departmentID') == false) {
        Session::flash('message', 'Please select a department to proceed');
        return array('redirect' => '/dashboard/settings/privileges');
      }

      // Find the selected session
      $department = Department::find(Session::pull('departmentID'));

      if ($department == null) {
        Session::flash('message', 'Error: Department not found');
        return array('redirect' => '/dashboard/settings/privileges');
      }

      // Get the selected user ids from the request
      $users = $request->input('arrObjects');

      if (count($users) == 0) {
        Session::flash('message', 'No users selected.. Permissions unchanged');
        return array('redirect' => '/dashboard/settings/privileges');
      }

      // Assign given users to the selected department
      foreach ($users as $userID) {
        $department->Users()->attach($userID);
      }

      Session::flash('message', 'User permissions added');
      Session::flash('remember_id', $department->id);

      return array('redirect' => '/dashboard/settings/privileges');
    }

    /**
      * Removes selected users from a selected department
      * @param \Illuminate\Http\Request $request
      * @return array   Contains the redirect url to process after request
      */
    public function removeUser(Request $request)
    {

      if (Session::has('departmentID') == false) {
        Session::flash('message', 'Please select a department to proceed');
        return array('redirect' => '/dashboard/settings/privileges');
      }

      // Find selected department
      $department = Department::find(Session::pull('departmentID'));

      if ($department == null) {
        Session::flash('message', 'Error: Department not found');
        return array('redirect' => '/dashboard/settings/privileges');
      }

      // Get user is from the request
      $users = $request->input('arrObjects');

      if (count($users) == 0) {
        Session::flash('message', 'No users selected.. Permissions unchanged');
        return array('redirect' => '/dashboard/settings/privileges');
      }

      // Remove selected users from the department
      foreach ($users as $userID) {
        $department->Users()->detach($userID);
      }

      Session::flash('message', 'User permissions removed');
      Session::flash('remember_id', $department->id);

      return array('redirect' => '/dashboard/settings/privileges');
    }

    /**
      * Filters privileges by criteria
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function filter(Request $request)
    {
      $drpDepartment = $request->input('drpDepartments');
      $department = null;

      if ($drpDepartment == null)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'Please select a department');

      // Load the sepecifed department
      $department = Department::find($drpDepartment);

      if ($department == null)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'Error: Department not found');

      // Get users associated with this department
      $users = $department->Users()->get();
      Session::put('departmentID', $drpDepartment);

      $allowed_departments = Session::get('allowed_departments');
      Session::flash('remember_id', $department->id);

      $data = array(
        'allowed_departments' => $allowed_departments,
        'department' => $department,
        'users' => $users
      );

      return view('pages/privileges', $data);

    }

    /**
      * Processes input and determines the action to perform,
      * allows the user to get into add and remove modes
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function process(Request $request)
    {
      // Get inputs from request
      $btnFindAll = $request->input('btnFindAll');
      $btnAddMode = $request->input('btnAddMode');
      $btnRemoveMode = $request->input('btnRemoveMode');
      $btnToggle = $request->input('btnToggle');
      $mode = $request->input('mode');

      // Determine which mode to use
      if (isset($mode)) {
        if ($mode == 'add') {
          return $this->addUser($request);
        } else if ($mode == 'remove') {
          return $this->removeUser($request);
        }
      }

      // Determine operation
      if (isset($btnFindAll)) {

        // Filter users
        return $this->filter($request);

      } else if (isset($btnAddMode)) {

        // Add users to a department
        return $this->addMode($request);

      } else if (isset($btnRemoveMode)) {

        // Remove users from a department
        return $this->removeMode($request);

      } else if (isset($btnToggle)) {

        // Toggle a users permission
        return $this->togglePermission($request);

      } else {
        abort(401, 'Unauthorized');
      }
    }

    /**
      * Toggles a users access level between admin and user
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function togglePermission(Request $request)
    {

      if (Session::has('departmentID') == false)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'Please select a department to proceed');

      $departmentID = Session::get('departmentID');
      $userID = $request->input('userID');

      // Load theselected user and department
      $user = User::find($userID);
      $department = Department::find($departmentID);

      if ($user == null || $department == null)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'Error: User or Department not found');

      // Toggle based on current privileges
      if ($user->isAdmin($departmentID))
        $user->Departments()->updateExistingPivot($departmentID, array('is_admin' => 0));
      else {
        $user->Departments()->updateExistingPivot($departmentID, array('is_admin' => 1));
      }

      // Update info
      $users = $department->Users()->get();
      $allowed_departments = Session::get('allowed_departments');

      Session::flash('message', 'Account: '.$user->username.' access level updated');
      Session::flash('remember_id', $department->id);

      $data = array(
        'allowed_departments' => $allowed_departments,
        'department' => $department,
        'users' => $users,
      );

      return view('pages/privileges', $data);

    }
}
