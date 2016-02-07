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
      $skins = Skin::all();

      $data = array(
        'departments' => $departments,
        'skins' => $skins,
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

    /**
      * Processes input from the screen. Includes basic CRUD and filtering options
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function process(Request $request)
    {

      $departments = null;
      $user = Session::get('user');
      $match_departments = Session::get('match_departments');

      // Get all inputs from request
      $btnAddDepartment = $request->input('btnAddDepartment');
      $btnFindDepartment = $request->input('btnFindDepartment');
      $btnFindAll = $request->input('btnFindAll');
      $departmentName = $request->input('txtDepartmentName');
      $skinID = $request->input('drpSkins');

      // Check which action to perform
      if (isset($btnAddDepartment)) {

        // Create new department
        $department = new Department();
        $department->name = $departmentName;
        $department->skin_id = $skinID;
        $department->save();

        // Make the creator of the department an admin
        $user->Departments()->attach($department->id, ['privilage_id' => '1']);
        array_push($match_departments, $department->id);

        // Reset department name so it doesn't appear on the form
        $departmentName = null;

        // Get all departments including new one
        //$departments = Department::all();

      } else if (isset($btnFindDepartment)) {

        // Get all departments LIKE the search string and with the same department
        // we don't care about  filtering by skin
        $departments = Department::where('name', 'LIKE', '%' . $departmentName . '%')->get();

      } else if (isset($btnFindAll)) {

        // Get all departments and clear search string
        $departmentName = null;
        //$departments = Department::all();

      } else {
        abort(401);
      }

      if ($departments == null) {
        if ($user->is_super_user) {
          $departments = Department::all();
        } else {
          $departments = Department::whereIn('id', $match_departments)->get();
        }
      }

      $data = array(
        'departments' => $departments,
        'skins' => Skin::all(),
        'departmentName' => $departmentName,
        'user' => $user
      );

      return view('pages/departments', $data);

    }
}
