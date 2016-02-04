<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Department as Department;
use App\Playlist as Playlist;
use App\Skin as Skin;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{

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

      $match_departments = Session::get('match_departments');

      $departments = Department::whereIn('id', $match_departments)->get();
      $playlists = Playlist::whereIn('department_id', $match_departments)->get();
      $skins = Skin::all();

      $data = array(
        'departments' => $departments,
        'skins' => $skins,
        'playlists' => $playlists
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

    public function process(Request $request)
    {
      // Get all inputs from request
      $btnAddDepartment = $request->input('btnAddDepartment');
      $btnFindDepartment = $request->input('btnFindDepartment');
      $btnFindAll = $request->input('btnFindAll');
      $departmentName = $request->input('txtDepartmentName');
      $playlistID = $request->input('drpPlaylists');
      $skinID = $request->input('drpSkins');

      // Check which action to perform
      if (isset($btnAddDepartment)) {

        // Create new department
        $department = new Department();
        $department->name = $departmentName;
        $department->skin_id = $skinID;
        $department->save();

        // Get all departments including new one
        $departments = Department::all();

      } else if (isset($btnFindDepartment)) {

        // Get all departments LIKE the search string and with the same department
        // we don't care about  filtering by skin
        $departments = Department::where('name', 'LIKE', '%' . $departmentName . '%');

      } else if (isset($btnFindAll)) {

        // Get all departments and clear search string
        $departmentName = null;
        $departments = Department::all();

      } else {
        abort(401);
      }

      $match_departments = Session::get('match_departments');
      $playlists = Playlist::whereIn('id', $match_departments)->get();

      $data = array(
        'departments' => $departments,
        'playlists' => $playlists,
        'skins' => Skin::all(),
        'departmentName' => $departmentName
      );

      return view('pages/departments', $data);

    }
}
