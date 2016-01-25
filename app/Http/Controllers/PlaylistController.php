<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

use App\Playlist as Playlist;
use App\Advert as Advert;
use App\Department as Department;

class PlaylistController extends Controller
{

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
      $allowed_departments = Session::get('allowed_departments');
      $match_departments = Session::get('match_departments');

      $playlists = Playlist::where('deleted', 0)->whereIn('department_id', $match_departments)->orderBy('name', 'ASC')->get();

      $data = array(
        'pageID' => '',
        'playlists' => $playlists,
        'allowed_departments' => $allowed_departments
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

      // Validation
      $this->validate($request, [
          'txtPlaylistName' => 'required|max:255',
      ]);

      // Was validation successful?
      $playlist = new Playlist;
      $playlist->name = $request->input('txtPlaylistName');
      $playlist->department_id = $request->input('drpDepartments');
      $playlist->save();

      $data = array(
        'pageID' => 'playlisteditor',
        'playlist' => $playlist
      );

      return view('pages/playlistEditor', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $match_departments = Session::get('match_departments');

      $playlist = Playlist::find($id);
      $adverts = $playlist->Adverts->where('deleted', 0);

      /*
      $filtered = $adverts->filter(function($item) use ($match_departments) {
        return in_array($item->department_id, $match_departments);
      });

      dd($adverts);*/

      $data = array(
        'pageID' => 'playlisteditor',
        'playlist' => $playlist,
        'adverts' => $adverts
      );

      return view('pages/playlistEditor', $data);
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
        $playlist = Playlist::find($id);
        //$advert = Advert::find($id,);

        dd($advert);
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

    public function addExistingAdvert($playlistID, $advertID)
    {
        $playlist = Playlist::find($playlistID);
        // TODO advert inde and display timing (GUI??)
        $playlist->Adverts()->attach($advertID, ['advert_index' => '1', 'display_schedule_id' => '1']);
        //dd($playlist);

        return redirect()->route('dashboard.playlist.show', $playlistID);
    }

    public function removeMode($playlistID)
    {
      //$allowed_departments = Session::get('allowed_departments');

      $playlist = Playlist::find($playlistID);
      $adverts = $playlist->Adverts->where('deleted', 0);//->whereIn('department_id', $allowed_departments);

      $data = array(
        'pageID' => 'playlisteditor',
        'playlist' => $playlist,
        'adverts' => $adverts,
        'deleteMode' => true
      );

      return view('pages/playlistEditor', $data);
    }

    public function removeAdvert($playlistID, $advertID)
    {
        $playlist = Playlist::find($playlistID);
        $playlist->Adverts()->detach($advertID);

        return redirect()->route('dashboard.playlist.show', $playlistID);
    }
}
