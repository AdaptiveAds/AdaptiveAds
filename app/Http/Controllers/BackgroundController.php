<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Background as Background;
use App\Helpers\Media;
use Session;
use Input;

/**
  * Defines the CRUD methods for the BackgroundController
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
class BackgroundController extends Controller
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
      //Get all backgrounds
      $backgrounds = Background::all();

      $data = array(
        'backgrounds' => $backgrounds
      );

      return view('pages/backgroundsEditor', $data);
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
      // Get request inputs
      $txtbackgroundName = $request->input('txtBackgroundName');
      $hexbackgroundColor = $request->input('hexBackgroundColor');

      $data = array(
        'name' => $txtBackgroundName,
      );

      // Validate inputs
      $reponse = $this->create_validator($data);
      if (isset($reponse)) {
        return $reponse;
      }

      // Create new background
      $background = new Background();
      $background->name = $txtbackgroundName;

      // Upload image 1
      $imageInput = Input::file('filBackgroundImage');
      if ($imageInput != null) {
        $imagePath = Media::processMedia($imageInput, 'advert_backgrounds/');

        // If we have a valid image then set the path in the database
        if ($imagePath != null) {
          $background->image_path = $imagePath;
        }
      }

      $background->hex_colour = $hexbackgroundColor;

      $background->save(); // Update

      return redirect()->route('dashboard.settings.backgrounds.index')
                       ->with('message', 'Background created successfully');
    }

    /**
     * Display the specified resource.
     * @param \Illuminate\Http\Request $request
     * @param  int  $id ID of the background to show
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      // Must be an ajax request
      if ($request->ajax() == false)
        abort(401, 'Unauthorized');

      // Get selected background
      $background = Background::find($id);
      if ($background == null)
        return array('error' => 'Error: Background not found.');

      return array('background' => $background);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id ID of the background to edit
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
     * @param  int  $id ID of the background to update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // Get selected background
      $background = Background::find($id);

      if ($background == null)
        return redirect()->route('dashboard.settings.backgrounds.index')
                         ->with('message', 'Error: Background not found');

      // Get request inputs
      $txtbackgroundName = $request->input('txtBackgroundName');
      $hexbackgroundColor = $request->input('hexBackgroundColor');

      $data = array(
        'name' => $txtBackgroundName,
      );

      // Validator
      $reponse = $this->edit_validator($data);
      if (isset($reponse)) {
        return $reponse;
      }

      $background->name = $txtbackgroundName;

      // Upload image 1
      $imageInput = Input::file('filBackgroundImage');
      if ($imageInput != null) {
        $imagePath = Media::processMedia($imageInput, 'advert_backgrounds/');

        // If we have a valid image then set the path in the database
        if ($imagePath != null) {
          $background->image_path = $imagePath;
        }
      }

      $background->hex_colour = $hexbackgroundColor;

      $background->save(); // Update

      return redirect()->route('dashboard.settings.backgrounds.index')
                       ->with('message', 'Background updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // Get selected Background
      $background = Background::find($id);

      if ($background == null)
        return redirect()->route('dashboard.settings.backgrounds.index')
                         ->with('message', 'Error: Background not found');

      // Ensure this background is not assigned to an advert
      $count = $background->Adverts()->count();
      if ($count != 0)
        return redirect()->route('dashboard.settings.backgrounds.index')
                         ->with('message', 'Unable to delete ' . $background->name . ', as one or more adverts require it.');

      $background->delete(); // Delete

      return redirect()->route('dashboard.settings.backgrounds.index')
                       ->with('message', 'Background deleted successfully');
    }

    /**
      * Filter backgrounds by criteria
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function filter(Request $request)
    {
      $user = Session::get('user');

      // Get request inputs
      $btnFindbackground = $request->input('btnFindBackground');
      $btnFindAll = $request->input('btnFindAll');
      $backgroundName = $request->input('txtBackgroundName');

      // Get all backgrounds
      $backgrounds = Background::all();

      // Check which action to perform
      if (isset($btnFindbackground)) {

        $filtered = collect([]);

        // First filter by name
        if ($backgroundName != null) {
          $filtered = $backgrounds->filter(function($item) use ($backgroundName) {
            if (strpos($item->name, $backgroundName) !== false) { // Get rough match
              return true;
            }
          });
        }

        $backgrounds = $filtered;

      } else if (isset($btnFindAll)) {

        // Reset search input box
        $backgroundName = null;

      } else {
        abort(401, 'Un-authorised');
      }

      $data = array(
        'user' => $user,
        'backgrounds' => $backgrounds
      );

      return view('pages/backgroundsEditor', $data);
    }

    /**
      * Validates input before creating a selected object
      * @param  array   $data array of fields to validate
      * @return \Illuminate\Http\Response response if validation fails
      */
    protected function create_validator(array $data) {

      // Validate
      $validator = Validator::make($data, [
        'name' => 'required|max:40|unique:background',
      ]);

      // If validator fails get the errors and warn the user
      // this redirects to prevent further execution
      if ($validator->fails()) {
        $message = Helper::getValidationErrors($validator);

        return redirect()->route('dashboard.settings.backgrounds.index')
        ->with('message', $message);
      }

    }

    /**
      * Validates input before creating a selected object
      * @param  array   $data array of fields to validate
      * @return \Illuminate\Http\Response response if validation fails
      */
    protected function edit_validator(array $data) {

      // Valitate
      $validator = Validator::make($data, [
        'name' => 'required|max:40|unique:background'
      ]);

      // If validator fails get the errors and warn the user
      // this redirects to prevent further execution
      if ($validator->fails()) {
        $message = Helper::getValidationErrors($validator);

        return redirect()->route('dashboard.settings.backgrounds.index')
        ->with('message', $message);
      }

    }
}
