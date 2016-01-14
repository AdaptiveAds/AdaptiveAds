<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Screen as Screen;
use App\Playlist as Playlist;

use App\Events\DurationEvent;

use Session;

class ServeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $screen = Screen::find($id);
        $playlist = $screen->Location->Playlist;

        $playlist = $this->loadPlaylist($playlist);

        $data = array(
          'pageTitle' => '',
          'screen' => $screen,
          'playlist' => $playlist
        );

        return view('templates/templateLayout', $data);
    }

    public function loadPlaylist($playlistID)
    {
      $current_advert_index = Session::get('current_advert_index', 1);
      $current_page_index = Session::get('current_page_index', 1);

      return $playlist = Playlist::with(['adverts'=>function($query) use ($current_advert_index) {
            //$query->where('advert_index', '=', $current_advert_index);
        }])
        ->with(['adverts.page'=>function($query) use ($current_page_index) {
            //$query->where('page_index', '=', $current_page_index);
        }])
        ->with('adverts.page.pageData')
        ->with('adverts.page.template')
        ->where('id', '=', $playlistID->id)
        ->get();

      /*return $playlist = Playlist::with(['adverts'=>function($query) use ($current_advert_index) {
            $query->where('advert_index', '=', $current_advert_index);
        }])
        ->with(['adverts.page'=>function($query) use ($current_page_index) {
            //$query->where('page_index', '=', $current_page_index);
        }])
        ->with('adverts.page.pageData')
        ->with('adverts.page.template')
        ->where('id', '=', $playlistID->id)
        ->get();*/
    }

    public function sync($id)
    {
        $screen = Screen::find($id);
        $playlist = $screen->Location->Playlist;

        return $this->loadPlaylist($playlist);
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


}
