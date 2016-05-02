<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Skin as Skin;
use App\Helpers\Media;
use Session;
use Input;

/**
  * Defines the CRUD methods for the SkinController
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class SkinController extends Controller
{

    /**
      * Controller Constructor defines what middleware to apply
      */
    public function __construct()
    {
        // Auth required
        $this->middleware('auth');
        $this->middleware('adminAccess');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $skins = Skin::all();

      $data = array(
        'skins' => $skins
      );

      return view('pages/skinsEditor', $data);
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
      $txtSkinName = $request->input('txtSkinName');
      $hexSkinColor = $request->input('hexSkinColor');

      $skin = new Skin();
      $skin->name = $txtSkinName;

      // Upload image 1
      $imageInput = Input::file('filSkinImage');
      if ($imageInput != null) {
        $imagePath = Media::processMedia($imageInput, 'advert_skins/');

        // If we have a valid image then set the path in the database
        if ($imagePath != null) {
          $skin->image_path = $imagePath;
        }
      }

      $skin->hex_colour = $hexSkinColor;

      $skin->save();

      return redirect()->route('dashboard.settings.skins.index')
                       ->with('message', 'Skin created successfully');
    }

    /**
     * Display the specified resource.
     * @param \Illuminate\Http\Request $request
     * @param  int  $id ID of the skin to show
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      $skin = Skin::find($id);
      if ($skin == null)
        return array('error' => 'Error: Skin not found.');

      return array('skin' => $skin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id ID of the skin to edit
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
     * @param  int  $id ID of the skin to update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $skin = Skin::find($id);

      if ($skin == null)
        return redirect()->route('dashboard.settings.skins.index')
                         ->with('message', 'Error: Skin not found');

      $txtSkinName = $request->input('txtSkinName');
      $hexSkinColor = $request->input('hexSkinColor');

      $skin->name = $txtSkinName;

      // Upload image 1
      $imageInput = Input::file('filSkinImage');
      if ($imageInput != null) {
        $imagePath = Media::processMedia($imageInput, 'advert_skins/');

        // If we have a valid image then set the path in the database
        if ($imagePath != null) {
          $skin->image_path = $imagePath;
        }
      }

      $skin->hex_colour = $hexSkinColor;

      $skin->save();

      return redirect()->route('dashboard.settings.skins.index')
                       ->with('message', 'Skin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $skin = Skin::find($id);

      if ($skin == null)
        return redirect()->route('dashboard.settings.skins.index')
                         ->with('message', 'Error: Skin not found');

      $count = $skin->Departments()->count();
      if ($count != 0)
        return redirect()->route('dashboard.settings.skins.index')
                         ->with('message', 'Unable to delete ' . $skin->name . ', as one or more departments require it.');

      $skin->delete();

      return redirect()->route('dashboard.settings.skins.index')
                       ->with('message', 'Skin deleted successfully');
    }

    /**
      * Filter skins by criteria
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function filter(Request $request)
    {
      $user = Session::get('user');

      $btnFindSkin = $request->input('btnFindSkin');
      $btnFindAll = $request->input('btnFindAll');
      $skinName = $request->input('txtSkinName');

      $skins = Skin::all();

      // Check which action to perform
      if (isset($btnFindSkin)) {

        $filtered = collect([]);

        // First filter by name
        if ($skinName != null) {
          $filtered = $skins->filter(function($item) use ($skinName) {
            if (strpos($item->name, $skinName) !== false) { // Get rough match
              return true;
            }
          });
        }

        $skins = $filtered;

      } else if (isset($btnFindAll)) {

        $skinName = null;

      } else {
        abort(401, 'Un-authorised');
      }

      $data = array(
        'user' => $user,
        'skins' => $skins
      );

      return view('pages/skinsEditor', $data);
    }
}
