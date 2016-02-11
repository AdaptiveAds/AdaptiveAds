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

/**
  * Defines the CRUD methods for the AdvertController
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class AdvertController extends Controller
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

        $adverts = Advert::whereIn('department_id', $match_departments)->get();

        //dd($adverts);

        $data = array(
          'user' => $user,
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
      $txtAdvertName = $request->input('txtAdvertName');
      $departmentID = $request->input('drpDepartments');

      $advert = new Advert();
      $advert->name = $txtAdvertName;
      $advert->department_id = $departmentID;
      $advert->save();

      return redirect()->route('dashboard.advert.index');
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

      $advert = Advert::find($id);

      if ($advert == null)
        abort(404, 'Not found.');

      return array('advert' => $advert);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $advert = Advert::find($id);

      if ($advert != null) {

        $txtAdvertName = $request->input('txtAdvertName');
        $departmentID = $request->input('drpDepartments');

        $advert->name = $txtAdvertName;
        $advert->department_id = $departmentID;
        $advert->save();

      } else {
        abort(404, 'Not found.');
      }

      return redirect()->route('dashboard.advert.index');
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

    /**
      * Displays a list of adverts the user can add to the playlist
      * @param int $playlistID ID of the selected playlist
      * @return \Illuminate\Http\Response
      */
    public function selectForPlaylist($playlistID)
    {
      $allowed_departments = Session::get('allowed_departments');
      $match_departments = Session::get('match_departments');
      $user = Session::get('user');

      $adverts = Advert::leftJoin('advert_playlist', function ($join) use ($playlistID) {
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

      if ($adverts->count() <= 0) {
        return response('Not found.', 404); // Advert does not exist or un authorised
      }

      $data = array(
        'adverts' => $adverts,
        'selectedPlaylist' => $playlistID,
        'allowed_departments' => $allowed_departments,
        'selectable' => true,
        'user' => $user
      );

      return view('pages/adverts', $data);
    }

    /**
      * Updates an advert with a new index and also updates the effected
      * avdert whom has been 'jumped' over.
      * @param \Illuminate\Http\Request $request
      * @param int $advertID
      * @return \Illuminate\Http\Response
      */
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

    /**
      * Processes input from the screen. Includes basic CRUD and filtering options
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function process(Request $request) {

      $user = Session::get('user');
      $allowed_departments = Session::get('allowed_departments');

      $btnAddAdvert = $request->input('btnAddAdvert');
      $btnFindAdvert = $request->input('btnFindAdvert');
      $btnFindAll = $request->input('btnFindAll');
      $advertName = $request->input('txtAdvertName');
      $departmentID = $request->input('drpDepartments');

      if (isset($btnAddAdvert)) {

        $advert = new Advert;
        $advert->name = $advertName;
        $advert->department_id = $departmentID;
        $advert->save();

        $advertName = null;
        $adverts = $this->getAllowedAdverts($user, $allowed_departments);

      } else if (isset($btnFindAdvert)) {

        $adverts = $this->getAllowedAdverts($user, $allowed_departments);
        $adverts = $adverts->filter(function($item) use ($advertName) {
          if ($item->name == $advertName) { // TODO Add department filter
            return true;
          }

          return false;
        });

      } else if (isset($btnFindAll)) {

        $advertName = null;
        $adverts = $this->getAllowedAdverts($user, $allowed_departments);

      } else {
        abort(401, 'Un-authorised');
      }

      $data = array(
        'user' => $user,
        'adverts' => $adverts,
        'allowed_departments' => $allowed_departments
      );

      return view('pages/adverts', $data);
    }

    /**
      * Gets an array of all the allowed averts the specified user is able
      * to access and modify because they're admin
      * @param User $user
      * @param array $allowed_departments
      * @return EloquentCollection
      */
    public function getAllowedAdverts($user, $allowed_departments) {
      // Check if super or admin
      if ($user->is_super_user) {
        return Advert::all(); // Return all adverts
      } else {

        $adverts = collect([]);
        // Get every user assigned to every department
        // this admin is responsible for
        foreach ($allowed_departments as $department) {
          $departmentAdverts = $department->Adverts()->get();

          if ($departmentAdverts->count() > 0) {
            $adverts = $adverts->merge($departmentAdverts);
          }
        }
      }

      // Only return unqiue users
      return $adverts->unique('id');
    }
}
