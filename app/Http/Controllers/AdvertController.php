<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

use App\Advert as Advert;
use App\Playlist as Playlist;
use App\Department as Department;

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
        $allowed_departments = Session::get('allowed_departments');
        $match = array();
        foreach ($allowed_departments as $department) {
          array_push($match, $department->id);
        }

        $adverts = Advert::where('deleted', 0)->whereIn('department_id', $match)->get();

        //dd($adverts);

        $data = array(
          'pageID' => '',
          'adverts' => $adverts,
          'allowed_departments' => $allowed_departments
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
        /*$advert = new Advert;

        $data = array(
          'pageID' => 'adverteditor',
          'advert' => $advert
        );

        return view('pages/advertEditor', $data);*/
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
        $advert->name = $request->input('txtAdvertName');
        $advert->department_id = $request->input('drpDepartments');
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
      $allowed_departments = Session::get('allowed_departments');
      $advert = Advert::find($id)->whereIn('department_id', $allowed_departments)->get();

      if ($advert->isEmpty()) {
        return response('Unauthorized.', 401); // User does not have access to this adverts' location
      }

      $pages = $advert->Pages->where('deleted', 0); // Ordered by page index

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
        $allowed_departments = Session::get('allowed_departments');
        $advert = Advert::find($id)->whereIn('department_id', $allowed_departments)->get();

        if ($advert->isEmpty()) {
          return response('Not found.', 404); // User does not have access to this adverts' location
        }

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
        $allowed_departments = Session::get('allowed_departments');
        $advert = Advert::find($id)->whereIn('department_id', $allowed_departments)->get();

        if ($advert->isEmpty()) {
          return response('Not found.', 404); // Advert does not exist or un authorised
        }

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
      $allowed_departments = Session::get('allowed_departments');
      $advert = Advert::find($id)->whereIn('department_id', $allowed_departments)->get();

      if ($advert->isEmpty()) {
        return response('Not found.', 404); // Advert does not exist or un authorised
      }

      $advert->deleted = 1;

      $advert->save();

      return redirect('dashboard/advert');
    }

    public function selectForPlaylist($playlistID)
    {
      $allowed_departments = Session::get('allowed_departments');
      $adverts = Advert::where('deleted', 0)->whereIn('department_id', $allowed_departments)->orderBy('name', 'ASC')->get();

      if ($adverts->isEmpty()) {
        return response('Not found.', 404); // Advert does not exist or un authorised
      }

      $data = array(
        'pageID' => '',
        'adverts' => $adverts,
        'selectedPlaylist' => $playlistID
      );

      return view('pages/adverts', $data);
    }
}
