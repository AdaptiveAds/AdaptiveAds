<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Screen as Screen;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScreenController extends Controller
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
        $screens = Screen::all();
        $allowed_departments = Session::get('allowed_departments');

        $data = array(
          'pageID' => '',
          'screens' => $screens,
          'allowed_departments' => $allowed_departments
        );

        return view('pages/screens', $data);
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
      // Get inputs from POST
      $btnAddScreen = $request->input('btnAddScreen');
      $btnFindScreen = $request->input('btnFindScreen');
      $btnFindAll = $request->input('btnFindAll');
      $locationID = $request->input('drpLocations');
      $playlistID = $request->inpu ('drpPlaylists');
      $screenID = $request->input('txtScreenID');

      // Check which action to perform
      if (isset($btnAddScreen)) {

        // Create new screen
        $screen = new Screen();
        $screen->location_id = $locationID; // assign location
        $screen->playlist_id = $playlistID or 1; // Set playlist of none selected set default
        $screen->save();

        $screenID = null;
        $screens = Screen::all(); // Return all screens

      } else if (isset($btnFindScreen)) {

        // Find a screen with the same id and department
        $screens = Screen::where('id', '=', $screenID)->where('department_id', '=', $departmentID)->get();

      } else if (isset($btnFindAll)) {

        // return all screens clear saved id
        $screenID = null;
        $screens = Screen::all();

      } else {
        abort(401);
      }

      // Pass back so we can re-populate the departments list
      $allowed_departments = Session::get('allowed_departments');

      $data = array(
        'pageID' => '',
        'screens' => $screens,
        'screenID' => $screenID,
        'allowed_departments' => $allowed_departments
      );

      return view('pages/screens', $data);
    }
}
