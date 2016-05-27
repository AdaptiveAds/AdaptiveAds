<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use DB;

use App\Playlist as Playlist;
use App\Advert as Advert;
use App\Department as Department;
use App\Schedule as Schedule;
use App\AdvertSchedule as AdvertSchedule;
use App\Helpers\Helper as Helper;

/**
  * Defines the CRUD methods for the PlaylistController
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class PlaylistController extends Controller
{

    /**
      * Controller Constructor defines what middleware to apply
      */
    public function __construct()
    {
        // Auth required
        $this->middleware('auth');
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

      // Return all playlists the user is allowed to see
      $playlists = Playlist::whereIn('department_id', $match_departments)->orderBy('name', 'ASC')->get();

      $data = array(
        'playlists' => $playlists,
        'allowed_departments' => $allowed_departments,
        'user' => $user
      );

      return view('pages/playlists', $data);
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
      $txtPlaylistName = $request->input('txtPlaylistName');
      $departmentID = $request->input('drpDepartments');

      $data = array(
        'txtPlaylistName' => $txtPlaylistName,
        'drpDepartments' => $departmentID,
      );

      $rules = array(
        'txtPlaylistName' => 'required|min:1|max:40|unique:playlist,name',
        'drpDepartments' => 'required|exists:department,id'
      );

      // Validate
      $reponse = Helper::validator($data, $rules, 'dashboard.playlist.index');
      if (isset($reponse)) {
        return $reponse;
      }

      $playlist = new Playlist;
      $playlist->name = $txtPlaylistName;
      $playlist->department_id = $departmentID;
      $playlist->save();

      return redirect()->route('dashboard.playlist.index')
                       ->with('message', 'Playlist created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id ID of the playlist to show
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      // Prevent access if not an ajax request
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      $playlist = Playlist::find($id);
      if ($playlist == null)
        return array('error' => 'Error: Playlist not found.');

      return array('playlist' => $playlist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id ID of the playlist to edit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $match_departments = Session::get('match_departments');

      $playlist = Playlist::find($id);

      if (isset($playlist) == false)
        return redirect()->route('dashboard.playlist.index')
                         ->with('message', 'Error: Playlist not found');

      $adverts = $playlist->Adverts()->get();

      $data = array(
        'playlist' => $playlist,
        'adverts' => $adverts
      );

      return view('pages/playlistEditor', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id ID of the playlist to update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $playlist = Playlist::find($id);

      if ($playlist == null)
        return redirect()->route('dashboard.playlist.index')
                         ->with('message', 'Error: Playlist not found');

      $txtPlaylistName = $request->input('txtPlaylistName');
      $departmentID = $request->input('drpDepartments');

      $data = array(
        'txtPlaylistName' => $txtPlaylistName,
        'drpDepartments' => $departmentID,
      );

      $rules = array(
        'txtPlaylistName' => 'required|min:1|max:40|unique:playlist,name,'.$id,
        'drpDepartments' => 'required|exists:department,id'
      );

      // Validate
      $reponse = Helper::validator($data, $rules, 'dashboard.playlist.index');
      if (isset($reponse)) {
        return $reponse;
      }

      $playlist->name = $txtPlaylistName;
      $playlist->department_id = $departmentID;
      $playlist->save();

      return redirect()->route('dashboard.playlist.index')
                       ->with('message', 'Playlist updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id ID of the playlist to destroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $playlist = Playlist::find($id);

      if ($playlist == null)
        return redirect()->route('dashboard.playlist.index')
                         ->with('message', 'Error: Playlist not found');

      // NOTE Global playlist cannot be deleted
      if ($playlist->isGlobal == true)
        abort(401, 'Unauthorized');

      $adCount = $playlist->Adverts()->count();
      $scCount = $playlist->Screens()->count();

      if ($scCount != 0)
        return redirect()->route('dashboard.playlist.index')
                         ->with('message', 'Unable to delete ' . $playlist->name
                                            . ', one or more screens depends on it');

      $playlist->delete();

      return redirect()->route('dashboard.playlist.index')
                       ->with('message', 'Playlist deleted successfully');
    }

    /**
      * Displays the add mode page and loads the page
      * with all adverts not associated with the selected playlist
      * @param Illuminate\Http\Request $request
      * @return Illuminate\Http\Response
      */
    public function addMode(Request $request)
    {
      $match_departments = Session::get('match_departments');
      $playlistID = $request->input('playlistID');
      $playlist = Playlist::find($playlistID);

      if ($playlist == null)
        return redirect()->route('dashboard.playlist.edit', array($playlistID))
                         ->with('message', 'Error: Playlist not found');

      $adverts = Advert::leftJoin('advert_playlist', function ($join) use ($playlistID) {
        $join->on('advert.id', '=', 'advert_playlist.advert_id');
        $join->where('advert_playlist.playlist_id', '=', $playlistID);
      })
      ->where('advert_playlist.playlist_id', '!=', $playlistID)
      ->orWhereRaw('advert_playlist.playlist_id is null')
      ->whereIn('advert.department_id', $match_departments)
      ->get();

      if ($adverts->count() <= 0)
        return redirect()->route('dashboard.playlist.edit', array($playlistID))
                         ->with('message', 'No available adverts to assign');

      Session::put('playlistID', $playlistID);

      $schedules = Schedule::all();

      $data = array(
        'adverts' => $adverts,
        'playlist' => $playlist,
        'schedules' => $schedules
      );

      return view('pages/adverts_addMode', $data);

    }

    /**
      * Displays the remove mode page and loads the page
      * with all adverts associated with the selected playlist
      * @param Illuminate\Http\Request $request
      * @return Illuminate\Http\Response
      */
    public function removeMode(Request $request)
    {
      $playlistID = $request->input('playlistID');

      $playlist = Playlist::find($playlistID);

      if ($playlist == null)
        return redirect()->route('dashboard.playlist.edit', array($playlistID))
                         ->with('message', 'Error: Playlist not found');

      $adverts = $playlist->Adverts()->get();

      if ($adverts->count() == 0)
        return redirect()->route('dashboard.playlist.edit', array($playlistID))
                         ->with('message', 'No adverts to remove');

      Session::put('playlistID', $playlistID);

      $data = array(
        'adverts' => $adverts,
        'playlist' => $playlist
      );

      return view('pages/adverts_removeMode', $data);
    }

    /**
      * AJAX Only Method
      * Adds an existing advert to the current playlist. If the request was
      * not made by an AJAX method HTTP 401 will be returned
      * @param Illuminate\Http\Request $request
      */
    public function addAdvert(Request $request)
    {
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      if (Session::has('playlistID') == false) {
        Session::flash('message', 'Error: playlist id not found');
        return array('redirect' => '/dashboard/playlist');
      }

      $playlistID = Session::pull('playlistID');
      $playlist = Playlist::find($playlistID);

      if ($playlist == null) {
        Session::flash('message', 'Error: playlist id not found');
        return array('redirect' => '/dashboard/playlist');
      }

      $adverts = $request->input('arrObjects');

      $currentIndex = DB::table('advert_playlist')->where('playlist_id', $playlistID)->max('advert_index');
      $count = 0;

      // Apply global restrictions
      if ($playlist->isGlobal == true) {
        $count = $playlist->Adverts()->count();
      }

      $extraArgs = $request->input('extra');
      $display_schedule_id = 1;
      if ($extraArgs['key'] == 'schedule') {
        $display_schedule_id = $extraArgs['data'];
      }

      foreach ($adverts as $advertID) {

        // NOTE global is restricted to a MAX of 3 adverts
        if ($count >= 3) {
            Session::flash('message', 'Global playlist has reached the maxiumum assigned');
            return array('redirect' => '/dashboard/playlist/'.$playlistID.'/edit');
        }

        // TODO advert inde and display timing (GUI??)
        $playlist->Adverts()->attach($advertID, ['advert_index' => ++$currentIndex]);

        // Create a new schedule
        $schedule = new AdvertSchedule();
        $schedule->playlist_id = $playlist->id;
        $schedule->advert_id = $advertID;
        $schedule->schedule_id = $display_schedule_id;
        $schedule->save();

        $count++;
      }

      Session::flash('message', 'Advert(s) added');
      return array('redirect' => '/dashboard/playlist/'.$playlistID.'/edit');
    }

    /**
      * AJAX Only Method
      * Removes a selected advert from the current playlist. If the request
      * was not made by a AJAX request HTTP 401 will be returned.
      * @param Illuminate\Http\Request $request
      */
    public function removeAdvert(Request $request)
    {
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      if (Session::has('playlistID') == false) {
        Session::flash('message', 'Error no playlist id found');
        return array('redirect' => '/dashboard/playlist');
      }

      $playlistID = Session::pull('playlistID');
      $playlist = Playlist::find($playlistID);

      if ($playlist == null) {
        Session::flash('message', 'Error: playlist id not found');
        return array('redirect' => '/dashboard/playlist');
      }

      $adverts = $request->input('arrObjects');

      foreach($adverts as $advertID) {
        $playlist->Adverts()->detach($advertID);
        $schedule = AdvertSchedule::where('playlist_id', $playlist->id)
                            ->where('advert_id', $advertID)
                            ->delete();
      }

      Session::flash('message', 'Advert(s) removed');
      return array('redirect' => '/dashboard/playlist/'.$playlistID.'/edit');
    }

    /**
      * AJAX Only Method
      * Updates the indexes of a selected playlist and the effected playlist
      * that has been jumped over. If the request was not made by a AJAX request
      * HTTP 401 will be returned.
      * @param Illuminate\Http\Request $request
      * @param int $playlistID  ID of the playlist to modify
      * @return Illuminate\Http\Response
      */
    public function updateIndexes(Request $request, $playlistID)
    {

      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      // Get ids from request
      $selectedID = $request->input('itemID');
      $effectedID = $request->input('effectedID');

      $playlist = Playlist::find($playlistID);

      // Can't find the playlist don't continue
      if (isset($playlist) == false) {
        abort(404);
      }

      foreach ($playlist->Adverts as $advert) {
        if ($advert->id == $selectedID) {
          $advert->pivot->advert_index = $request->input('newIndex');
          $advert->pivot->save();
        } else if ($advert->id == $effectedID) {
          $advert->pivot->advert_index = $request->input('effectedIndex');
          $advert->pivot->save();
        }
      }

      return response('Success', 200);
    }

    /**
      * Filters playlists by criteria
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function filter(Request $request) {

      $user = Session::get('user');
      $allowed_departments = Session::get('allowed_departments');

      $btnFindPlaylist = $request->input('btnFindPlaylist');
      $btnFindAll = $request->input('btnFindAll');
      $playlistName = $request->input('txtPlaylistSearch');
      $departmentID = $request->input('drpDepartments');

      $playlists = $this->getAllowedPlaylists($user, $allowed_departments);

      // Check which action to perform
      if (isset($btnFindPlaylist)) {

        $filtered = collect([]);

        // Search by name
        if ($playlistName != null) {
          $filtered = $playlists->filter(function($item) use ($playlistName) {
            if (strpos($item->name, $playlistName) !== false) { // check for rough match
              return true;
            }
          });
        }

        // Search by department
        if ($filtered->count() == 0) {
          $filtered = $playlists->filter(function($item) use ($departmentID) {
            if ($item->department_id == $departmentID) {
              return true;
            }
          });
        }

        $playlists = $filtered;

      } else if (isset($btnFindAll)) {

        $playlistName = null;

      } else {
        abort(401, 'Un-authorised');
      }

      $data = array(
        'user' => $user,
        'allowed_departments' => $allowed_departments,
        'playlists' => $playlists
      );

      return view('pages/playlists', $data);
    }

    /**
      * Gets an array of all the allowed playlists the specified user is able
      * to access and modify because they're admin
      * @param User $user
      * @param array $allowed_departments
      * @return EloquentCollection
      */
    public function getAllowedPlaylists($user, $allowed_departments)
    {
      // Check if super or admin
      if ($user->is_super_user) {
        return Playlist::all(); // Return all adverts
      } else {

        $playlists = collect([]);
        // Get every user assigned to every department
        // this admin is responsible for
        foreach ($allowed_departments as $department) {
          $departmentPlaylists = $department->Playlists()->get();

          if ($departmentPlaylists->count() > 0) {
            $playlists = $playlists->merge($departmentPlaylists);
          }
        }
      }

      // Only return unqiue users
      return $playlists->unique('id');
    }

    /**
      * Processes input and determines the action to undertake,
      * mostly to determine which mode to perform add or remove
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function process(Request $request)
    {
      $btnAddMode = $request->input('btnAddMode');
      $btnRemoveMode = $request->input('btnRemoveMode');
      $mode = $request->input('mode');

      if (isset($mode)) {
        if ($mode == 'add') {
          return $this->addAdvert($request);
        } else if ($mode == 'remove') {
          return $this->removeAdvert($request);
        }
      } else if (isset($btnAddMode)) {

        return $this->addMode($request);

      } else if (isset($btnRemoveMode)) {

        return $this->removeMode($request);

      } else {
        abort(401, 'Unauthorized');
      }

    }
}
