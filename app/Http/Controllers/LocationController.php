<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Location as Location;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LocationController extends Controller
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

      $allowed_departments = Session::get('allowed_departments');

      $locations = Location::all();

      $data = array(
        'pageID' => '',
        'locations' => $locations,
        'allowed_departments' => $allowed_departments
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
        $locations = Location::all();

      } else if (isset($btnFindLocation)) {

        // Get all locations that are LIKE the provided name
        $locations = Location::where('name', 'LIKE', '%' . $locationName . '%')
                             ->get();

      } else if (isset($btnFindAll)) {

        // Get all locations and surpress any search input
        $locationName = null;
        $locations = Location::all();

      } else {
        abort(401);
      }

      //dd($locations);

      $data = array(
        'pageID' => '',
        'locations' => $locations,
        'searchItem' => $locationName
      );

      return view('pages/locations', $data);

    }
}
