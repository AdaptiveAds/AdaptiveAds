<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Skin as Skin;
use Session;

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
      $txtSkinClass = $request->input('txtSkinClass');

      $skin = new Skin();
      $skin->name = $txtSkinName;
      $skin->class_name = $txtSkinClass;
      $skin->save();

      return redirect()->route('dashboard.settings.skins.index');
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
        abort(404, 'Not found.');

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
        abort(404, 'Not Found.');

      $txtSkinName = $request->input('txtSkinName');
      $txtSkinClass = $request->input('txtSkinClass');

      $skin->name = $txtSkinName;
      $skin->class_name = $txtSkinClass;
      $skin->save();

      return redirect()->route('dashboard.settings.skins.index');
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
      $skinClass = $request->input('txtSkinClass');

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

        // If no results found filter by class name
        if ($skinClass != null) {
          if ($filtered->count() == 0) {
            $filtered = $skins->filter(function($item) use ($skinClass) {
              if (strpos($item->class_name, $skinClass) !== false) { // Get rough match
                return true;
              }
            });
          }
        }

        $skins = $filtered;

      } else if (isset($btnFindAll)) {

        $skinName = null;
        $skinClass = null;

      } else {
        abort(401, 'Un-authorised');
      }

      $data = array(
        'user' => $user,
        'skins' => $skins
      );

      return view('pages/skinsEditor', $data);
    }

    /**
      * Soft deletes a specified resource
      * @param int  $id ID of the skin to soft delete
      * @return \Illuminate\Http\Response
      */
    public function toggleDeleted($id)
    {
      $skin = Skin::find($id);

      if ($skin == null)
        abort(404, 'Not found.');

      if ($skin->deleted == 0) {
        $skin->deleted = 1;
      } else {
        $skin->deleted = 0;
      }

      $skin->save();

      return redirect()->route('dashboard.settings.skins.index');
    }
}
