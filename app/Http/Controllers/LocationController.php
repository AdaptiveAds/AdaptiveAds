<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\playlist as Playlist;
use App\Location as Location;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper as Helper;

/**
  * Defines the CRUD methods for the LocationController
  * @author Josh Preece
  * @license MIT
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

      $playlists = Playlist::whereIn('department_id', $match_departments)->get();

      // Return all locations or only the ones th user is assigned to
      if ($user->is_super_user) {
        $locations = Location::all();
      } else {
        $locations = Location::whereIn('department_id', $match_departments)->get();
      }

      $data = array(
        'locations' => $locations,
        'allowed_departments' => $allowed_departments,
        'user' => $user,
        'playlists' => $playlists
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
      // Get request inputs
      $txtLocationName = $request->input('txtLocationName');
      $departmentID = $request->input('drpDepartments');
      $playlistID = $request->input('drpPlaylists');

      $data = array(
        'txtLocationName' => $txtLocationName,
        'drpDepartments' => $departmentID,
        'drpPlaylists' => $playlistID
      );

      $rules = array(
        'txtLocationName' => 'required|max:40|unique:location,name',
        'drpDepartments' => 'required|exists:department,id',
        'drpPlaylists' => 'required|exists:playlist,id'
      );

      // Validate input
      $reponse = Helper::validator($data,$rules,'dashboard.settings.locations.index');
      if (isset($reponse)) {
        return $reponse;
      }

      // Create new location
      $location = new Location();
      $location->name = $txtLocationName;
      $location->department_id = $departmentID;
      $location->playlist_id = $playlistID;
      $location->save();

      return redirect()->route('dashboard.settings.locations.index')
                       ->with('message', 'Location created successfully');
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

      // find selected location
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
      // NOTE not used
      return Response('Not found', 404);
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
      // Get selected location
      $location = Location::find($id);

      if ($location == null)
        return redirect()->route('dashboard.settings.locations.index')
                         ->with('message', 'Error: Location not found');

      // Request input
      $txtLocationName = $request->input('txtLocationName');
      $departmentID = $request->input('drpDepartments');
      $playlistID = $request->input('drpPlaylists');

      $data = array(
        'txtLocationName' => $txtLocationName,
        'drpDepartments' => $departmentID,
        'drpPlaylists' => $playlistID
      );

      $rules = array(
        'txtLocationName' => 'required|max:40|unique:location,name,'.$id,
        'drpDepartments' => 'required|exists:department,id',
        'drpPlaylists' => 'required|exists:playlist,id'
      );

      // Validate input
      $reponse = Helper::validator($data,$rules,'dashboard.settings.locations.index');
      if (isset($reponse)) {
        return $reponse;
      }

      // Update location
      $location->name = $txtLocationName;
      $location->department_id = $departmentID;
      $location->playlist_id = $playlistID;
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
      // Get selected location
      $location = Location::find($id);

      if ($location == null)
        return redirect()->route('dashboard.settings.locations.index')
                         ->with('message', 'Error: Location not found');

      // Ensure no screens depend of the location
      $count = $location->Screens->count();
      if ($count != 0)
        return redirect()->route('dashboard.settings.locations.index')
                         ->with('message', 'Unable to delete location as one or more screens depend on it');

      // Delete
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
