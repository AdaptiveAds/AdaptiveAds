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
     * Calculate a precise time difference.
     * @param string $start result of microtime()
     * @param string $end result of microtime(); if NULL/FALSE/0/'' then it's now
     * @return flat difference in seconds, calculated with minimum precision loss
     * @Author https://gist.github.com/hadl/5721816
     */
      public function microtime_diff($start, $end = null)
      {
        if (!$end) {
        	$end = microtime();
        }
        list($start_usec, $start_sec) = explode(" ", $start);
        list($end_usec, $end_sec) = explode(" ", $end);
        $diff_sec = intval($end_sec) - intval($start_sec);
        $diff_usec = floatval($end_usec) - floatval($start_usec);
        return floatval($diff_sec) + $diff_usec;
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
        $playlistID = $screen->Location->Playlist;
        //dd($adverts);
        // Get session vars
        $last_check = Session::get('last_check_time', 0);
        $current_advert_index = Session::get('current_advert_index', 1);
        $current_page_index = Session::get('current_page_index', 1);

        //dd($current_advert_index);

        // http://laravel.io/forum/02-10-2014-several-eager-loading-with-constraints
        //$adverts = Playlist::with('adverts.page.pageData')->get();

        // Eager load the current advert and associated page
        $playlist = Playlist::with(['adverts'=>function($query) use ($current_advert_index) {
              $query->where('advert_index', '=', $current_advert_index);
          }])
          ->with(['adverts.page'=>function($query) use ($current_page_index) {
              $query->where('page_index', '=', $current_page_index);
          }])
          ->with('adverts.page.pageData')
          ->with('adverts.page.template')
          ->where('id', '=', $playlistID->id)
          ->get();

        //dd($playlist);

        $timeDifference = round((strtotime("2016-01-14 00:02:00") - time()) / 60,2);

        if ($timeDifference <= $playlist[0]->adverts[0]
                                    ->page[0]
                                    ->template
                                    ->duration)
        {
            // Set session vars
            Session::put('last_check_time', time());
            Session::put('current_advert_index', ++$current_advert_index);
            Session::put('current_page_index', ++$current_page_index);

            // Get the new data
            $playlist = Playlist::with(['adverts'=>function($query) use ($current_advert_index) {
                $query->where('advert_index', '=', $current_advert_index);
            }])
            ->with(['adverts.page'=>function($query) use ($current_page_index) {
                $query->where('page_index', '=', $current_page_index);
            }])
            ->with('adverts.page.pageData')
            ->with('adverts.page.template')
            ->where('id', '=', $playlistID->id)
            ->get();

            // TODO ENABLE!! ----> event(new DurationEvent("RELOAD"));

            //dd("OVER " . $timeDifference . ' == ' . Session::get('current_advert_index'));
        }

        Session::save();
        //dd("GOOD " . $timeDifference . ' === ' . Session::get('current_advert_index'));

        $data = array(
          'pageTitle' => '',
          'playlist' => $playlist
        );

        return view('templates/templateLayout', $data);
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
