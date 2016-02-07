<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Screen as Screen;
use App\Playlist as Playlist;

use App\Events\DurationEvent;

/**
  * Defines the CRUD methods for the ServeController
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
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
        //$screen_playlists = $screen->with('department.playlists.adverts')->get();

        if (isset($screen) == false) {
          return response('Not found', 404);
        }

        $data = array(
          'screen' => $screen
        );

        return view('templates/templateLayout', $data);
    }

    /**
      * Gets the playlist associated with the screen and loads all realtions
      * @param Screen $screen
      * @return EloquentCollection
      */
    public function loadPlaylists($screen)
    {

      /*return $screen
                    ->with('playlist.adverts.pages')
                    ->with('playlist.adverts.pages.pageData')
                    ->with('playlist.adverts.pages.template')
                    ->first();*/

      return $screen->where('id', $screen->id)->with(array('playlist' => function($query) {
          $query->with(array('adverts' => function($query) {
              $query->where('deleted', 0);
            }));
          $query->with(array('adverts.pages' => function($query) {
            $query->where('deleted', 0);
            $query->with('pageData');
            $query->with('template');
          }));
        }))->first();

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

    /**
      * Gets the global playlist and loads all realtions
      * @return EloquentCollection
      */
    public function getGlobal()
    {
      return Playlist::where('isGlobal', true)
                      ->with(array('adverts' => function($query) {
                          $query->where('deleted', 0);
                        }))
                      ->with(array('adverts.pages' => function($query) {
                        $query->where('deleted', 0);
                        $query->with('pageData');
                        $query->with('template');
                      }))->first();
    }

    /**
      * Calls loadPlaylist and getGlobal to pass back any changes to the client
      * @param int $id
      * @return \Illuminate\Http\Response
      */
    public function sync($id)
    {
        $screen = Screen::find($id);
        //$playlist = $screen->Location->Playlist;

        if (isset($screen) == false) {
          return response('Not found', 404);
        }

        $data = array(
          'data' => $this->loadPlaylists($screen),
          'global' => $this->getGlobal()
        );

        //dd($data);

        return $data;
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
