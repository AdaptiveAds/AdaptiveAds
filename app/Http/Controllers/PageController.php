<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Media;
use App\Helpers\Helper as Helper;

use Input;

use App\Page as Page;
use App\PageData as PageData;
use App\Template as Template;
use App\Advert as Advert;
use App\Background as Background;

/**
  * Defines the CRUD methods for the PageController
  * @author Josh Preece
  * @license MIT
  * @since 1.0
  */
class PageController extends Controller
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
      // NOTE not used
      return Response('Not found', 404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($adID)
    {
        $page = new Page;
        $page->advert_id = $adID;

        $advert = Advert::find($adID);
        if ($advert == null)
          return redirect()->route('dashboard.advert.index')
                           ->with('message', 'Could not find selected advert');

        $count = $advert->Pages->count();
        if ($count >= 4)
          return redirect()->route('dashboard.advert.index')
                           ->with('message', 'Maximum number of pages reached');

        // Returns all possible templates to assign to the page
        $templates = Template::all();

        $data = array(
          'page' => $page,
          'templates' => $templates,
          'activeTemplate' => $templates[0]
        );

        return view('pages/pageeditor', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $adID)
    {
      $txtHeading = $request->input('txtPageName');
      $txtContent = $request->input('txtPageContent');
      $templateID = $request->input('txtTemplate');
      $txtTransition = $request->input('drpTransitions');
      $txtDirection = $request->input('drpTransitionDirection');

      $data = array(
        'txtPageName' => $txtHeading,
        'txtContent' => $txtContent,
        'templateID' => $templateID
      );

      $rules = array(
        'txtPageName' => 'max:255',
        'txtContent' => 'max:255',
        'templateID' => 'required|exists:template,id',
      );

      // Validate input
      $reponse = Helper::validator($data,$rules,'dashboard.advert.index', [$adID]);
      if (isset($reponse)) {
        return $reponse;
      }

      // Create new page data
      $pageData = new PageData;
      $pageData->heading = $txtHeading;
      $pageData->content = $txtContent;

      // Upload image 1
      $imageInput = Input::file('filPageImage');
      if ($imageInput != null) {
        $imagePath = Media::processMedia($imageInput, 'advert_images/');

        // If we have a valid image then set the path in the database
        if ($imagePath != null) {
          $pageData->image_path = $imagePath;
        }
      }

      // Upload video 1
      $videoInput = Input::file('filPageVideo');
      if ($videoInput != null) {
        $videoPath = Media::processMedia($videoInput, 'advert_videos/');

        // If we have a valid image then set the path in the database
        if ($videoPath != null) {
          $pageData->video_path = $videoPath;
        }
      }

      // Save!
      $pageData->save();

      // Create a new page
      $page = new Page;
      $page->page_data_id = $pageData->id;
      $page->page_index = Page::where('advert_id', $adID)->count(); // Add to end
      $page->advert_id = $adID;
      $page->template_id = $templateID;
      $page->transition = $txtTransition . $txtDirection;
      $page->save();

      $btnSaveClose = $request->input('btnSaveClose');

      if(isset($btnSaveClose))
        return redirect()->route('dashboard.advert.index', [$adID, $page->id])
                         ->with('message', 'Page saved!');

      return redirect()->route('dashboard.advert.{adID}.page.show', [$adID, $page->id])
                       ->with('message', 'Page created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id ID of the page to show
     * @return \Illuminate\Http\Response
     */
    public function show($adID, $id)
    {
      $match = ['id' => $id, 'deleted' => 0];
      $page = Page::where($match)->first(); // one to one only return 1

      if ($page == null)
        return redirect()->route('dashboard.advert.index')
                         ->with('message', 'Error: Could not find page');

      $pageData = $page->PageData->where('id', $page->page_data_id)->orderBy('heading', 'ASC')->first();

      $advert = Advert::find($adID);

      if ($advert == null)
        return redirect()->route('dashboard.advert.index')
                         ->with('message', 'Error: Advert removed before update');

      $background = Background::find($advert->background_id);

      if ($background == null)
        return redirect()->route('dashboard.advert.index')
                         ->with('message', 'Error: Background removed before update');

      $data = array(
        'page' => $page,
        'pageData' => $pageData,
        'activeTemplate' => $page->Template,
        'templates' => Template::all(),
        'advertBackground' => $background
      );

      return view('pages/pageeditor', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id ID of the page to edit
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
     * @param  int  $adID ID of the advert the page belongs to
     * @param  int  $id   ID of the page to update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $adID, $id)
    {
      $txtHeading = $request->input('txtPageName');
      $txtContent = $request->input('txtPageContent');
      $templateID = $request->input('txtTemplate');
      $txtTransition = $request->input('drpTransitions');
      $txtDirection = $request->input('drpTransitionDirection');

      $data = array(
        'txtPageName' => $txtHeading,
        'txtContent' => $txtContent,
        'txtTemplate' => $templateID
      );

      $rules = array(
        'txtPageName' => 'max:255',
        'txtContent' => 'max:255',
        'txtTemplate' => 'required|exists:template,id',
      );

      // Validate input
      $response = Helper::validator($data,$rules,'dashboard.advert.index');
      if (isset($response)) {
        return $response;
      }

      $page = Page::find($id);
      $page->template_id = $templateID;
      $page->transition = $txtTransition . $txtDirection;
      $page->save();

      $pageData = $page->PageData;
      $pageData->heading = $txtHeading;
      $pageData->content = $txtContent;

      // Upload image 1
      $imageInput = Input::file('filPageImage');
      if ($imageInput != null) {
        $imagePath = Media::processMedia($imageInput, 'advert_images/');

        // If we have a valid image then set the path in the database
        if ($imagePath != null) {
          $pageData->image_path = $imagePath;
        }
      }

      $videoInput = Input::file('filPageVideo');
      if ($videoInput != null) {
        $videoPath = Media::processMedia($videoInput, 'advert_videos/');

        // If we have a valid image then set the path in the database
        if ($videoPath != null) {
          $pageData->video_path = $videoPath;
        }
      }

      $pageData->save();

      $btnSaveClose = $request->input('btnSaveClose');
      if(isset($btnSaveClose))
        return redirect()->route('dashboard.advert.index', [$adID, $page->id])
                         ->with('message', 'Page saved!');

      return redirect()->route('dashboard.advert.{adID}.page.show', [$adID, $page->id])
                       ->with('message', 'Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id ID of the page to destroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($adID, $id)
    {
        $page = Page::find($id);

        if ($page == null)
          return redirect()->route('dashboard.advert.edit', [$adID])
                           ->with('message', 'Error: Page not found');

        $page->deleted = 1;
        $page->save();

        return redirect()->route('dashboard.advert.edit', [$adID])
                         ->with('message', 'Page deleted successfully');
    }

    /**
      * Removes media from a page by removing the path to the
      * file. NOTE this does not delete physical files off disk
      * this must be done by an external process
      *
      * @param \Illuminate\Http\Request $request
      * @param int $adID  Advert ID to return to
      * @param int $id  Page ID to update and remove media
      * @return \Illuminate\Http\Response
      */
    public function removeMedia(Request $request, $adID, $id)
    {
      $mediaType = $request->input('mediaType');
      $page = Page::find($id);

      if ($page == null)
        abort(404);

      if ($mediaType == 'image') {
        $page->PageData->image_path = "";
      } else if ($mediaType == 'video') {
        $page->PageData->video_path = "";
      } else {
        abort(401);
      }

      $page->PageData->save();

      return redirect()->route('dashboard.advert.{adID}.page.show', [$adID, $id])
                       ->with('message', 'Page updated successfully');
    }
}
