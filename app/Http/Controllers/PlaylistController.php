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

      // TODO VALIDATION

      // Was validation successful?
      $playlist = new Playlist;
      $playlist->name = $request->input('txtPlaylistName');
      $playlist->department_id = $request->input('drpDepartments');
      $playlist->save();

      $data = array(
        'playlist' => $playlist
      );

      return redirect()->route('dashboard.playlist.index');
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

      $playlist = Playlist::find($id);
      if ($playlist == null)
        abort(404, 'Not found.');

      return array('playlist' => $playlist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $match_departments = Session::get('match_departments');

      $playlist = Playlist::find($id);

      if (isset($playlist) == false) {
        return response('Not found', 404);
      }

      $adverts = $playlist->Adverts->where('deleted', 0); // ordered by advert_index

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $playlist = Playlist::find($id);

      if ($playlist != null) {

        $txtPlaylistName = $request->input('txtPlaylistName');
        $departmentID = $request->input('drpDepartments');
        $chkIsGlobal = $request->input('chkIsGlobal');

        $playlist->name = $txtPlaylistName;
        $playlist->isGlobal = $chkIsGlobal;
        $playlist->department_id = $departmentID;
        $playlist->save();

      } else {
        abort(404, 'Not found.');
      }

      return redirect()->route('dashboard.playlist.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $match_departments = Session::get('match_departments');
      $playlist = Playlist::where('id', $id)->whereIn('department_id', $match_departments)->first();

      if (isset($playlist) == false) {
        return response('Un-authorised', 401);
      }
      // $playlist->Adverts()->detach(); // TODO Remove all associated adverts??

      $playlist->deleted = 1;
      $playlist->save();

      return redirect()->route('dashboard.playlist.index');
    }

    public function addExistingAdvert(Request $request)
    {

      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      $playlistID = $request->input('playlistID');
      $adverts = $request->input('arrAdverts');

      $playlist = Playlist::find($playlistID);

      $currentIndex = DB::table('advert_playlist')->where('playlist_id', $playlistID)->max('advert_index');

      foreach ($adverts as $advertID) {
        // TODO advert inde and display timing (GUI??)
        $playlist->Adverts()->attach($advertID, ['advert_index' => ++$currentIndex, 'display_schedule_id' => '1']);
      }
    }

    public function removeAdvert(Request $request)
    {
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      $playlistID = $request->input('playlistID');
      $adverts = $request->input('arrAdverts');

      $playlist = Playlist::find($playlistID);

      foreach($adverts as $advertID) {
        $playlist->Adverts()->detach($advertID);
      }
    }

    public function updateIndexes(Request $request, $playlistID)
    {

      // Get ids from request
      $selectedID = $request->input('itemID');
      $effectedID = $request->input('effectedID');

      $playlist = Playlist::find($playlistID);

      // Can't find the playlist don't continue
      if (isset($playlist) == false) {
        abort(404);
      }

      //dd($playlist);

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
      * Processes input from the screen. Includes basic CRUD and filtering options
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function process(Request $request) {

      $user = Session::get('user');
      $allowed_departments = Session::get('allowed_departments');

      $btnAddPlaylist = $request->input('btnAddPlaylist');
      $btnFindPlaylist = $request->input('btnFindPlaylist');
      $btnFindAll = $request->input('btnFindAll');
      $playlistName = $request->input('txtPlaylistName');
      $departmentID = $request->input('drpDepartments');

      if (isset($btnAddPlaylist)) {

        $playlist = new Playlist;
        $playlist->name = $playlistName;
        $playlist->department_id = $departmentID;
        $playlist->save();

        $playlistName = null;
        $playlists = $this->getAllowedPlaylists($user, $allowed_departments);

      } else if (isset($btnFindPlaylist)) {



      } else if (isset($btnFindAll)) {

        $playlistName = null;
        $playlists = $this->getAllowedPlaylists($user, $allowed_departments);

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
    public function getAllowedPlaylists($user, $allowed_departments) {
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
}
