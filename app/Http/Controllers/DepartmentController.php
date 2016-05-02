<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Department as Department;
use App\Playlist as Playlist;
use App\Skin as Skin;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
  * Defines the CRUD methods for the DepartmentController
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class DepartmentController extends Controller
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
      $match_departments = Session::get('match_departments');

      $departments = Department::whereIn('id', $match_departments)->get();

      $data = array(
        'departments' => $departments,
        'user' => $user
      );

      return view('pages/departments', $data);
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
      $txtDepartmentName = $request->input('txtDepartmentName');

      if (isset($txtDepartmentName) == false)
        return redirect()->route('dashboard.settings.departments.index')
                         ->with('message', 'Error: Please enter a department name');

      $department = new Department();
      $department->name = $txtDepartmentName;
      $department->save();

      return redirect()->route('dashboard.settings.departments.index')
                       ->with('message', 'Department saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id ID of the department to show
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      // Prevent access if not an ajax request
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      $department = Department::find($id);

      if ($department == null)
        return array('error' => 'Error: Department not found.');

      return array('department' => $department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id ID of the department to edit
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
     * @param  int  $id ID of the department to update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $department = Department::find($id);

      if ($department == null)
        return redirect()->route('dashboard.settings.departments.index')
                         ->with('message', 'Error: Department not found');

      $txtDepartmentName = $request->input('txtDepartmentName');

      $department->name = $txtDepartmentName;
      $department->save();

      return redirect()->route('dashboard.settings.departments.index')
                       ->with('message', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id ID of the department to destroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = Session::get('user');

      if ($user->is_super_user == false)
        abort(401, 'Unauthorized');

      $department = Department::find($id);

      if ($department == null)
        return redirect()->route('dashboard.settings.departments.index')
                         ->with('message', 'Error: Department not found');

      $adCount = $department->Adverts()->count();
      $plCount = $department->Playlists()->count();

      if ($adCount != 0 || $plCount != 0)
        return redirect()->route('dashboard.settings.departments.index')
                         ->with('message', 'Unable to delete ' . $department->name
                                            . ', one or more adverts and playlists depend on it');

      $department->delete();

      return redirect()->route('dashboard.settings.departments.index')
                       ->with('message', 'Department deleted successfully');
    }

    /**
      * Filters departments by criteria
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function filter(Request $request)
    {

      $departments = null;
      $user = Session::get('user');
      $match_departments = Session::get('match_departments');

      // Get all inputs from request
      $btnFindDepartment = $request->input('btnFindDepartment');
      $btnFindAll = $request->input('btnFindAll');
      $departmentName = $request->input('txtDepartmentName');

      $match_departments = Session::get('match_departments');
      $departments = Department::whereIn('id', $match_departments)->get();

      // Check which action to perform
      if (isset($btnFindDepartment)) {

        $filtered = collect([]);

        // Filter by name
        if ($departmentName != null) {
          $filtered = $departments->filter(function($item) use ($departmentName) {
            if (strpos($item->name, $departmentName) !== false) { // Get rough match
              return true;
            }
          });
        }

        $departments = $filtered;

      } else if (isset($btnFindAll)) {

        // Get all departments and clear search string
        $departmentName = null;
        //$departments = Department::all();

      } else {
        abort(401, 'Unauthorized');
      }

      $data = array(
        'departments' => $departments,
        'departmentName' => $departmentName,
        'user' => $user
      );

      return view('pages/departments', $data);

    }
}
