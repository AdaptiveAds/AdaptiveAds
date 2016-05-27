<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Screen as Screen;
use App\Playlist as Playlist;
use App\Advert as Advert;

use App\Events\DurationEvent;

use View;

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
      // NOTE not used
      return Response('Not found', 404);
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
      // NOTE not used
      return Response('Not found', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Load specified screen
        $screen = Screen::find($id);

        if (isset($screen) == false)
          abort(404, 'Not found');

        // Eager load playlist
        $screen = $this->loadPlaylists($screen);

        // Filter out adverts that can't be shown during this time
        $adverts = $this->applySchedule($screen->playlist->adverts);

        // Get the active template to load first
        $activeTemplate = "template1"; // assign default
        if ($adverts->count() > 0) {
          $activeTemplate = $adverts[0]->Pages[0]->Template;
        }

        $global = $this->getGlobal();

        $data = array(
          'screen' => $screen,
          'playlist' => $screen->playlist,
          'adverts' => $adverts,
          'pageData' => $global->adverts[0]->pages[0]->pageData,
          'global' => $global,
          'activeTemplate' => $activeTemplate,
          'serve' => true
        );

        return view('templateDefault', $data);
    }

    /**
      * Only returns playlists that have a schedule allowing
      * them to display at thie current time
      * @param collection $adverts  Adverts to filter
      * @param collection of process adverts allow to display now
      */
    public function applySchedule($adverts) {
      $time = date('H:i:s', Time());
      $processed = $adverts->filter(function($item) use ($time) {
        $schedule = $item->advertSchedule->schedule;
        if ($schedule->anyTime == true)
          return true;
        if ($time > $schedule->start_time && $time < $schedule->end_time)
          return true;
      })->values();

      return $processed;
    }

    /**
      * Gets the playlist associated with the screen and loads all realtions
      * @param Screen $screen
      * @return EloquentCollection
      */
    public function loadPlaylists($screen)
    {

      return $screen->where('id', $screen->id)->with(array('playlist' => function($query) {
          $query->with('adverts.background');
          $query->with('adverts.advertSchedule.schedule');
          $query->with(array('adverts.pages' => function($query) {
            $query->where('deleted', 0);
            $query->with('pageData');
            $query->with('template');
          }));
        }))->first();
    }

    /**
      * Gets the global playlist and loads all realtions
      * @return EloquentCollection
      */
    public function getGlobal()
    {
      return Playlist::where('isGlobal', true)
                      ->with('adverts')
                      ->with('adverts.background')
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
      // Load the selected screen
      $screen = Screen::find($id);

      if (isset($screen) == false) {
        return response('Not found', 404);
      }

      // Eager load playlists
      $data = $this->loadPlaylists($screen);
      $adverts = $this->applySchedule($data->playlist->adverts);

      $data = array(
        'screen' => $screen,
        'playlist' => $data->playlist,
        'adverts' => $adverts,
        'global' => $this->getGlobal()
      );

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
      // NOTE not used
      return Response('Not found', 404);
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
      // NOTE not used
      return Response('Not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // NOTE not used
      return Response('Not found', 404);
    }


}
