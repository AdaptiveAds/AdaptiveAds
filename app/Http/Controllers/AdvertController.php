<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use DB;

use App\Advert as Advert;
use App\Playlist as Playlist;
use App\Department as Department;
use App\Page as Page;

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
        $match_departments = Session::get('match_departments');

        $adverts = Advert::where('deleted', 0)->whereIn('department_id', $match_departments)->get();

        //dd($adverts);

        $data = array(
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
      $match_departments = Session::get('match_departments');

      $advert = Advert::whereIn('department_id', $match_departments)->where('id', $id)->get();

      if ($advert->isEmpty()) {
        return response('Unauthorized.', 401); // User does not have access to this adverts' location
      } else {
        $advert = $advert->first();
      }

      $pages = $advert->Pages->where('deleted', 0); // Ordered by page index

      $data = array(
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
      // NOTE not used
      return Response('Not found', 404);
    /*
      $allowed_departments = Session::get('allowed_departments');
      $advert = Advert::find($id)->whereIn('department_id', $allowed_departments)->get();

      if ($advert->isEmpty()) {
        return response('Not found.', 404); // User does not have access to this adverts' location
      }

      $data = array(
        'pageID' => 'adverteditor',
        'advert' => $advert
      );

      return view('pages/advertEditor', $data);*/
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
      /*$allowed_departments = Session::get('allowed_departments');
      $advert = Advert::find($id)->whereIn('department_id', $allowed_departments)->get();

      if ($advert->isEmpty()) {
        return response('Not found.', 404); // Advert does not exist or un authorised
      }

      $advert->name = $request->name;

      $advert->save();*/
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
      $advert = Advert::where('id', $id)->whereIn('department_id', $match_departments)->first();

      if (isset($advert) == false) {
        return response('Un-authorised.', 401); // Advert does not exist or un authorised
      }

      $advert->deleted = 1;
      $advert->save();

      return redirect()->route('dashboard.advert.index');
    }

    public function selectForPlaylist($playlistID)
    {
      $allowed_departments = Session::get('allowed_departments');
      $match_departments = Session::get('match_departments');

      $adverts = DB::table('advert')->leftJoin('advert_playlist', function ($join) use ($playlistID) {
        $join->on('advert.id', '=', 'advert_playlist.advert_id');
        $join->where('advert_playlist.playlist_id', '=', $playlistID);
      })
      //->whereNull('playlist_id')
      //->where('advert_playlist.advert_id', '!=', 'advert.id')
      ->where('advert_playlist.playlist_id', '!=', $playlistID)
      ->orWhereRaw('advert_playlist.playlist_id is null')
      ->whereIn('advert.department_id', $match_departments)
      ->where('advert.deleted', '=', 0)
      ->get();

      if (count($adverts) <= 0) {
        return response('Not found.', 404); // Advert does not exist or un authorised
      }

      $data = array(
        'adverts' => $adverts,
        'selectedPlaylist' => $playlistID,
        'allowed_departments' => $allowed_departments
      );

      return view('pages/adverts', $data);
    }

    public function updateIndexes(Request $request, $advertID)
    {

      // Get ids from request
      $selectedID = $request->input('itemID');
      $effectedID = $request->input('effectedID');

      // Find pages to modify
      $selectedPage = Page::find($selectedID);
      $effectedPage = Page::find($effectedID);

      if (isset($selectedPage) == false || isset($effectedPage) == false) {
        abort(404); // If we can't find a page abort
      }

      // Update indexes
      $selectedPage->page_index = $request->input('newIndex');
      $effectedPage->page_index = $request->input('effectedIndex');

      // Save!
      $selectedPage->save();
      $effectedPage->save();

      return response('Success', 200);
    }

    public function process(Request $request) {

      // Validation
      $this->validate($request, [
          'txtAdvertName' => 'required|max:255',
      ]);

      $btnAddAdvert = $request->input('btnAddAdvert');
      $btnFindAdvert = $request->input('btnFindAdvert');
      $btnFindAll = $request->input('btnFindAll');
      $advertName = $request->input('txtAdvertName');

      if (isset($btnAddAdvert)) {

        $advert = new Advert;
        $advert->name = $request->input('txtAdvertName');
        $advert->department_id = $request->input('drpDepartments');
        $advert->save();

        $advertName = null;

      } else if (isset($btnFindAdvert)) {

        $adverts = Advert::where('name', 'LIKE', '%' . $advertName . '%')->get();

      } else if (isset($btnFindAll)) {

        $advertName = null;

      } else {
        abort(401, 'Un-authorised');
      }

      $data = array(
        'adverts' => $adverts
      );

      return view('pages/adverts', $data);
    }

    public function getAllowedAdverts($user, $allowed_departments) {
      // Check if super or admin
      if ($user->is_super_user) {
        return Adverts::all(); // Return all adverts
      } else {

        $adverts = collect([]);
        // Get every user assigned to every department
        // this admin is responsible for
        foreach ($allowed_departments as $department) {
          $departmentAdverts = $department->Adverts()->get();

          if ($departmentUsers->count() > 0) {
            $users = $users->merge($departmentUsers);
          }
        }
      }

      // Only return unqiue users
      return $adverts->unique('id');
    }
}
