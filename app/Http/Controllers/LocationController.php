<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Location as Location;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
  * Defines the CRUD methods for the LocationController
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class LocationController extends Controller
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
      $match_departments = Session::get('match_departments');

      if ($user->is_super_user) {
        $locations = Location::all();
      } else {
        $locations = Location::whereIn('department_id', $match_departments)->get();
      }

      $data = array(
        'locations' => $locations,
        'allowed_departments' => $allowed_departments,
        'user' => $user
      );

      return view('pages/locations', $data);
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
      $txtLocationName = $request->input('txtLocationName');
      $departmentID = $request->input('drpDepartments');

      $location = new Location();
      $location->name = $txtLocationName;
      $location->department_id = $departmentID;
      $location->save();

      return redirect()->route('dashboard.settings.locations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id ID of the location to show
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      // Prevent access if not an ajax request
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      $location = Location::find($id);
      if ($location == null)
        abort(404, 'Not found.');

      return array('location' => $location);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id ID of the location to edit
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
     * @param  int  $id ID of the location to update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $location = Location::find($id);

      if ($location != null) {

        $txtLocationName = $request->input('txtLocationName');
        $departmentID = $request->input('drpDepartments');

        $location->name = $txtLocationName;
        $location->department_id = $departmentID;
        $location->save();

      } else {
        abort(404, 'Not found.');
      }

      return redirect()->route('dashboard.settings.locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id ID of the location to destroy
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
      $locations = null;

      // Validate input
      $this->validate($request, [
          'txtLocationName' => 'required|max:255',
      ]);

      // Get all input vars
      $btnAddLocation = $request->input('btnAddLocation');
      $btnFindLocation = $request->input('btnFindLocation');
      $btnFindAll = $request->input('btnFindAll');
      $locationName = $request->input('txtLocationName');
      $departmentID = $request->input('drpDepartments');

      // Check which action to perform
      if (isset($btnAddLocation)) {

        // Create a new location object
        $location = new Location();
        $location->name = $locationName;
        $location->department_id = $departmentID;
        $location->save();

        // Reset location name so it doesn't appear on the form
        $locationName = null;

        // Get all locations
        //$locations = Location::all();

      } else if (isset($btnFindLocation)) {

        // Get all locations that are LIKE the provided name
        $locations = Location::where('name', 'LIKE', '%' . $locationName . '%')
                             ->get();

      } else if (isset($btnFindAll)) {

        // Get all locations and surpress any search input
        $locationName = null;
        //$locations = Location::all();

      } else {
        abort(401);
      }

      //dd($locations);
      $user = Session::get('user');
      $allowed_departments = Session::get('allowed_departments');
      $match_departments = Session::get('match_departments');

      if ($locations == null) {
        if ($user->is_super_user) {
          $locations = Location::all();
        } else {
          $locations = Location::whereIn('department_id', $match_departments)->get();
        }
      }

      $data = array(
        'locations' => $locations,
        'searchItem' => $locationName,
        'user' => $user,
        'allowed_departments' => $allowed_departments
      );

      return view('pages/locations', $data);

    }

    /**
      * Soft deletes a specified resource
      * @param int  $id ID of the location to soft delete
      * @return \Illuminate\Http\Response
      */
    public function toggleDeleted($id)
    {
      $location = Location::find($id);

      if ($location == null)
        abort(404, 'Not found.');

      if ($location->deleted == 0) {
        $location->deleted = 1;
      } else {
        $location->deleted = 0;
      }

      $location->save();

      return redirect()->route('dashboard.settings.locations.index');
    }
}
