<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Screen as Screen;
use App\Location as Location;
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
        $match_departments = Session::get('match_departments');
        $user = Session::get('user');

        $locations = Location::whereIn('department_id', $match_departments)->get();

        $data = array(
          'screens' => $screens,
          'locations' => $locations,
          'user' => $user
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
      $match_departments = Session::get('match_departments');
      $user = Session::get('user');

      // Get inputs from POST
      $btnAddScreen = $request->input('btnAddScreen');
      $btnFindScreen = $request->input('btnFindScreen');
      $btnFindAll = $request->input('btnFindAll');
      $locationID = $request->input('drpLocations');
      $playlistID = $request->input('drpPlaylists');
      $screenID = $request->input('txtScreenID');

      // Check which action to perform
      if (isset($btnAddScreen)) {

        if ($user->is_super_user) {
          // Create new screen
          $screen = new Screen();
          $screen->location_id = $locationID; // assign location
          $screen->playlist_id = $playlistID or 1; // Set playlist of none selected set default
          $screen->save();

          $screenID = null;
          $screens = Screen::all(); // Return all screens
        } else {
          abort(401, 'Un-authorised');
        }

      } else if (isset($btnFindScreen)) {

        /*$location = Location::find($locationID);

        // Double check the user can use this location ID
        if (in_array($location->department_id, $match_departments)) {
          // Find a screen with the same id and department*/
          $screens = Screen::where('id', '=', $screenID)->where('location_id', '=', $locationID)->get();
        /*} else {
          abort(401, 'Un-authorised');
        }*/

      } else if (isset($btnFindAll)) {

        $screenID = null;

        if ($user->is_super_user) {
          // return all screens clear saved id
          $screens = Screen::all();
        } else {

          // TODO REMOVE
          $screens = Screen::all();
          /*$allowed_departments = Session::get('allowed_departments');
          $screens = collect([]);
          foreach ($allowed_departments as $department) {
            $screens->merge($department->Screens()->get());
          }

          dd($screens);*/
        }

      } else {
        abort(401);
      }

      // Pass back so we can re-populate the locations list
      $locations = Location::whereIn('department_id', $match_departments)->get();

      $data = array(
        'screens' => $screens,
        'screenID' => $screenID,
        'locations' => $locations,
        'user' => $user
      );

      return view('pages/screens', $data);
    }
}
