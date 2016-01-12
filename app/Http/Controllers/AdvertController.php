<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Advert as Advert;
use App\PLaylist as Playlist;

class AdvertController extends Controller
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
        $adverts = Advert::where('advert_deleted', 0)->get();

        $data = array(
          'pageID' => '',
          'adverts' => $adverts
        );

        return view('pages/adverts', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $advert = new Advert;
        //$advert->save();

        $data = array(
          'pageID' => 'adverteditor',
          'advert' => $advert
        );

        return view('pages/advertEditor', $data);
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
            'txtAdvertName' => 'required|max:255',
        ]);

        // Was validation successful?
        $advert = new Advert;
        $advert->advert_name = $request->input('txtAdvertName');
        $advert->save();

        $data = array(
          'pageID' => 'adverteditor',
          'advert' => $advert
        );

        return view('pages/advertEditor', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $advert = Advert::find($id);
      $pages = $advert->Page->where('deleted', 0);

      $data = array(
        'pageID' => '',
        'advert' => $advert,
        'pages' => $pages
      );

      return view('pages/advertEditor', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advert = Advert::find($id);

        $data = array(
          'pageID' => 'adverteditor',
          'advert' => $advert
        );

        return view('pages/advertEditor', $data);
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
        $advert = Advert::find($id);

        $advert->name = $request->name;

        $advert->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $advert = Advert::find($id);

      $advert->advert_deleted = 1;

      $advert->save();

      return redirect('dashboard/advert');
    }

    public function selectForPlaylist($playlistID)
    {
      $adverts = Advert::where('advert_deleted', 0)->get();

      $data = array(
        'pageID' => '',
        'adverts' => $adverts,
        'selectedPlaylist' => $playlistID
      );

      return view('pages/adverts', $data);
    }
}
