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
  * @license REVIEW
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addMode(Request $request)
    {

      $allowed_departments = Session::get('allowed_departments');
      $departmentID = $request->input('drpDepartments');

      if ($departmentID == null)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'Please select a department to work with');

      $department = Department::find($departmentID);

      if ($department == null)
        abort(404, 'Not found');

      $depUsers = $department->Users()->get();
      $allUsers = User::all();

      $users = $allUsers->diff($depUsers);

      Session::put('departmentID', $departmentID);

      $data = array(
        'users' => $users,
        'allowed_departments' => $allowed_departments
      );

      return view('pages/privileges_addMode', $data);
    }

    public function removeMode(Request $request)
    {
      $allowed_departments = Session::get('allowed_departments');
      $departmentID = $request->input('drpDepartments');

      if ($departmentID == null)
        return redirect()->route('dashboard.settings.privileges.index')
                         ->with('message', 'Please select a department to work with');

      $department = Department::find($departmentID);

      if ($department == null)
        abort(404, 'Not found');

      $users = $department->Users()->get();

      Session::put('departmentID', $departmentID);

      $data = array(
        'users' => $users,
        'allowed_departments' => $allowed_departments
      );

      return view('pages/privileges_removeMode', $data);
    }

    public function addUser(Request $request)
    {
      if (Session::has('departmentID') == false) {
        Session::flash('message', 'Please select a department to proceed');
        return array('redirect' => '/dashboard/settings/privileges');
      }

      $department = Department::find(Session::pull('departmentID'));

      if ($department == null)
        abort(404, 'Not found');

      $users = $request->input('arrObjects');

      if (count($users) == 0) {
        Session::flash('message', 'No users selected.. Permissions unchanged');
        return array('redirect' => '/dashboard/settings/privileges');
      }

      foreach ($users as $userID) {
        $department->Users()->attach($userID);
      }

      Session::flash('message', 'User permissions added');

      return array('redirect' => '/dashboard/settings/privileges');
    }

    public function removeUser(Request $request)
    {
      if (Session::has('departmentID') == false) {
        Session::flash('message', 'Please select a department to proceed');
        return array('redirect' => '/dashboard/settings/privileges');
      }

      $department = Department::find(Session::pull('departmentID'));

      if ($department == null)
        abort(404, 'Not found');

      $users = $request->input('arrObjects');

      if (count($users) == 0) {
        Session::flash('message', 'No users selected.. Permissions unchanged');
        return array('redirect' => '/dashboard/settings/privileges');
      }

      foreach ($users as $userID) {
        $department->Users()->detach($userID);
      }

      Session::flash('message', 'User permissions removed');

      return array('redirect' => '/dashboard/settings/privileges');
    }

    public function filter(Request $request)
    {
      $drpDepartment = $request->input('drpDepartments');

      if ($drpDepartment !== null) {
        $department = Department::find($drpDepartment);

        $users = $department->Users()->get();
      }

      $allowed_departments = Session::get('allowed_departments');

      $data = array(
        'allowed_departments' => $allowed_departments,
        'users' => $users
      );

      return view('pages/privileges', $data);

    }

    public function process(Request $request)
    {
      //$request->session()->flush();
      $btnFindAll = $request->input('btnFindAll');
      $btnAddMode = $request->input('btnAddMode');
      $btnRemoveMode = $request->input('btnRemoveMode');
      $mode = $request->input('mode');

      if (isset($mode)) {
        if ($mode == 'add') {
          return $this->addUser($request);
        } else if ($mode == 'remove') {
          return $this->removeUser($request);
        }
      }

      if (isset($btnFindAll)) {

        return $this->filter($request);

      } else if (isset($btnAddMode)) {

        return $this->addMode($request);

      } else if (isset($btnRemoveMode)) {

        return $this->removeMode($request);

      } else {
        abort(401, 'Unauthorized');
      }
    }

    public function togglePermission(Request $request)
    {

    }
}
