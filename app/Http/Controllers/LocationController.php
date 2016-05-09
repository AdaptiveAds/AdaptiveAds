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
        return array('error', 'Error: Location not found.');

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

      if ($location == null)
        return redirect()->route('dashboard.settings.locations.index')
                         ->with('message', 'Error: Location not found');

      $txtLocationName = $request->input('txtLocationName');
      $departmentID = $request->input('drpDepartments');

      $location->name = $txtLocationName;
      $location->department_id = $departmentID;
      $location->save();

      return redirect()->route('dashboard.settings.locations.index')
                       ->with('message', 'Location updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id ID of the location to destroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $location = Location::find($id);

      if ($location == null)
        return redirect()->route('dashboard.settings.locations.index')
                         ->with('message', 'Error: Location not found');

      $count = $location->Screens->count();
      if ($count != 0)
        return redirect()->route('dashboard.settings.locations.index')
                         ->with('message', 'Unable to delete ' . $location . ', as one or more screens depend on it');

      $location->delete();

      return redirect()->route('dashboard.settings.locations.index')
                       ->with('message', 'Location deleted successfully');
    }

    /**
      * Filter locations by criteria
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function filter(Request $request)
    {
      $locations = null;

      // Get all input vars
      $btnFindLocation = $request->input('btnFindLocation');
      $btnFindAll = $request->input('btnFindAll');
      $locationName = $request->input('txtLocationName');
      $departmentID = $request->input('drpDepartments');

      $match_departments = Session::get('match_departments');
      $locations = Location::whereIn('department_id', $match_departments)->get();

      // Check which action to perform
      if (isset($btnFindLocation)) {

        $filtered = collect([]);

        // Filter by name
        if ($locationName != null) {
          $filtered = $locations->filter(function($item) use ($locationName) {
            if (strpos($item->name, $locationName) !== false) { // Get rough match
              return true;
            }
          });
        }

        // Filter by department id
        if ($filtered->count() == 0) {
          $filtered = $locations->filter(function($item) use ($departmentID) {
            if ($item->department_id == $departmentID) {
              return true;
            }
          });
        }

        $locations = $filtered;

      } else if (isset($btnFindAll)) {

        $locationName = null;

      } else {
        abort(401, 'Unauthorized');
      }

      $user = Session::get('user');
      $allowed_departments = Session::get('allowed_departments');

      $data = array(
        'locations' => $locations,
        'searchItem' => $locationName,
        'user' => $user,
        'allowed_departments' => $allowed_departments
      );

      return view('pages/locations', $data);

    }
}
