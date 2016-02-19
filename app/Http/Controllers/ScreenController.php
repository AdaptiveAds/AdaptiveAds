<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Screen as Screen;
use App\Location as Location;
use App\Playlist as Playlist;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
  * Defines the CRUD methods for the ScreenController
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class ScreenController extends Controller
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
        $match_departments = Session::get('match_departments');
        $allowed_departments = Session::get('allowed_departments');
        $user = Session::get('user');

        $locations = Location::whereIn('department_id', $match_departments)->get();
        $playlists = Playlist::whereIn('department_id', $match_departments)->get();

        // Get screens that the user has access to
        $screens = $this->getAllowedScreens($user, $allowed_departments);

        //dd($allowed_screens);

        $data = array(
          'screens' => $screens,
          'locations' => $locations,
          'user' => $user,
          'playlists' => $playlists
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
      $locationID = $request->input('drpLocations');
      $playlistID = $request->input('drpPlaylists');

      $screen = new Screen();
      $screen->location_id = $locationID;
      $screen->playlist_id = empty($playlistID)? 1 : $playlistID;
      $screen->save();

      return redirect()->route('dashboard.settings.screens.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      // Prevent access if not an ajax request
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      $screen = Screen::find($id);

      if ($screen == null)
        abort(404, 'Not found.');

      return array('screen' => $screen);
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
      $screen = Screen::find($id);

      if ($screen != null) {

        $locationID = $request->input('drpLocations');
        $playlistID = $request->input('drpPlaylists');

        $screen->location_id = $locationID;
        $screen->playlist_id = empty($playlistID)? 1 : $playlistID;
        $screen->save();

      } else {
        abort(404, 'Not found.');
      }

      return redirect()->route('dashboard.settings.screens.index');
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
      $match_departments = Session::get('match_departments');
      $allowed_departments = Session::get('allowed_departments');
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
          $screen->playlist_id = empty($playlistID)? 1 : $playlistID; // Set playlist of none selected set default
          $screen->save();

          $screenID = null;
          $screens = $this->getAllowedScreens($user, $allowed_departments);

        } else {
          abort(401, 'Un-authorised');
        }

      } else if (isset($btnFindScreen)) {

        $screens = $this->getAllowedScreens($user, $allowed_departments);
        $screens = $screens->filter(function($item) use ($screenID, $locationID) {
          if ($item->id == $screenID && $item->location_id == $locationID) {
            return true;
          }

          return false;
        });

      } else if (isset($btnFindAll)) {

        $screenID = null;
        $screens = $this->getAllowedScreens($user, $allowed_departments);

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

    /**
      * Gets an array of all the allowed screens the specified user is able
      * to access and modify because they're admin
      * @param User $user
      * @param array $allowed_departments
      * @return EloquentCollection
      */
    public function getAllowedScreens($user, $allowed_departments) {
      if ($user->is_super_user) {
        return Screen::all();
      } else {

        $screens = collect([]);
        foreach ($allowed_departments as $department) {
          $departmentScreens = $department->Screens()->get();

          if ($departmentScreens->count() > 0) {
            $screens = $screens->merge($departmentScreens);
          }
        }
      }

      return $screens;
    }

    public function toggleDeleted($id) {

      $screen = Screen::find($id);

      if ($screen == null)
        abort(404, 'Not found.');

      if ($screen->deleted == 0) {
        $screen->deleted = 1;
      } else {
        $screen->deleted = 0;
      }

      $screen->save();

      return redirect()->route('dashboard.settings.screens.index');
    }
}
