<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Playlist as Playlist;
use App\Advert as Advert;

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
      $playlists = Playlist::where('deleted', 0)->get();

      $data = array(
        'pageID' => '',
        'playlists' => $playlists
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
      $playlist->playlist_name = $request->input('txtPlaylistName');
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
      $playlist = Playlist::find($id);
      $adverts = $playlist->Adverts;

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
      $playlist = Playlist::find($id);
      // $playlist->Adverts()->detach(); // TODO Remove all associated adverts??

      $playlist->deleted = 1;
      $playlist->save();

      return redirect()->action('DashboardController@index');
    }

    public function addExistingAdvert($playlistID, $advertID)
    {
        $playlist = Playlist::find($playlistID);
        // TODO advert inde and display timing (GUI??)
        $playlist->Adverts()->attach($advertID, ['advert_index' => '1', 'display_timing_id' => '1']);

        return redirect()->route('dashboard.playlist.show', $playlistID);
    }

    public function removeMode($playlistID)
    {
      $playlist = Playlist::find($playlistID);
      $adverts = $playlist->Adverts;

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
