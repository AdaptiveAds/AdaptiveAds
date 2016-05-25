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

        // Return locations and playlits the user can access
        $locations = Location::whereIn('department_id', $match_departments)->get();
        $playlists = Playlist::whereIn('department_id', $match_departments)->get();

        // Get screens that the user has access to
        $screens = $this->getAllowedScreens($user, $allowed_departments);

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
      $locationID = $request->input('drpLocations');
      $playlistID = $request->input('drpPlaylists');

      // Create a new screen
      $screen = new Screen();
      $screen->location_id = $locationID;
      $screen->playlist_id = empty($playlistID)? 1 : $playlistID;
      $screen->save();

      return redirect()->route('dashboard.settings.screens.index')
                       ->with('message', 'Screen registered successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id ID of the screen to show
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      // Prevent access if not an ajax request
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      // Load selected screen
      $screen = Screen::find($id);

      if ($screen == null)
        return array('error' => 'Error: Screen not found.');

      return array('screen' => $screen);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id ID of the screen to edit
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
     * @param  int  $id ID of the screen to update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $screen = Screen::find($id);

      if ($screen == null)
        return redirect()->route('dashboard.settings.screens.index')
                         ->with('message', 'Error: Screen not found');

      
      $locationID = $request->input('drpLocations');
      $playlistID = $request->input('drpPlaylists');

      $screen->location_id = $locationID;
      $screen->playlist_id = empty($playlistID)? 1 : $playlistID;
      $screen->save();

      return redirect()->route('dashboard.settings.screens.index')
                       ->with('message', 'Screen updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id ID of the screen to destroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = Session::get('user');

      if ($user->is_super_user == false)
        abort(401, 'Unauthorized');

      $screen = Screen::find($id);

      if ($screen == null)
        return redirect()->route('dashboard.settings.screens.index')
                         ->with('message', 'Error: Screen not found');

      $screen->delete();

      return redirect()->route('dashboard.settings.screens.index')
                       ->with('message', 'Screen deleted successfully');
    }

    /**
      * Filter screens by criteria
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function filter(Request $request)
    {
      $match_departments = Session::get('match_departments');
      $allowed_departments = Session::get('allowed_departments');
      $user = Session::get('user');

      // Get inputs from POST
      $btnFindScreen = $request->input('btnFindScreen');
      $btnFindAll = $request->input('btnFindAll');
      $locationID = $request->input('drpLocations');
      $playlistID = $request->input('drpPlaylists');
      $screenID = $request->input('txtScreenID');

      // Check which action to perform
      if (isset($btnFindScreen)) {

        // Filter by id
        $screens = $this->getAllowedScreens($user, $allowed_departments);
        $filtered = $screens->filter(function($item) use ($screenID) {
          if ($item->id == $screenID) {
            return true;
          }
        });

        // Filter by location
        if ($filtered->count() == 0) {
          $filtered = $screens->filter(function($item) use ($locationID) {
            if ($item->location_id == $locationID) {
              return true;
            }
          });
        }

        $screens = $filtered;

      } else if (isset($btnFindAll)) {

        $screenID = null;
        $screens = $this->getAllowedScreens($user, $allowed_departments);

      } else {
        abort(401);
      }

      $playlists = Playlist::whereIn('department_id', $match_departments)->get();

      // Pass back so we can re-populate the locations list
      $locations = Location::whereIn('department_id', $match_departments)->get();

      $data = array(
        'screens' => $screens,
        'screenID' => $screenID,
        'locations' => $locations,
        'playlists' => $playlists,
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
}
