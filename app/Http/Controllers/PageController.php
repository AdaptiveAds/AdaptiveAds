<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Media;

use Input;

use App\Page as Page;
use App\PageData as PageData;
use App\Template as Template;

/**
  * Defines the CRUD methods for the PageController
  * @author Josh Preece
  * @license REVIEW
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

        $data = array(
          'page' => $page
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
      // Validation
      $this->validate($request, [
          'txtPageName' => 'required|max:255',
      ]);

      // Was validation successful?
      $pageData = new PageData;

      $pageData->heading = $request->input('txtPageName');
      $pageData->video_path = $request->input('txtPageVideo');
      $pageData->content = $request->input('txtPageContent');

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
        $videoPath = Media::processMedia($videoInput, 'advert_video/');

        // If we have a valid image then set the path in the database
        if ($videoPath != null) {
          $pageData->video_path = $videoPath;
        }
      }

      $pageData->save();

      $page = new Page;
      $page->page_data_id = $pageData->id;
      $page->page_index = Page::where('advert_id', $adID)->count(); // Add to end
      $page->advert_id = $adID;
      $page->template_id = $request->input('txtTemplate');
      $page->save();

      $data = array(
        'page' => $page
      );

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
      $pageData = $page->PageData->where('id', $page->page_data_id)->orderBy('heading', 'ASC')->first();

      $data = array(
        'page' => $page,
        'pageData' => $pageData,
        'activeTemplate' => $page->Template,
        'templates' => Template::all()
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

      // Validation
      $this->validate($request, [
          'txtPageName' => 'required|max:255',
      ]);

      $page = Page::find($id);
      $page->template_id = $request->input('txtTemplate');
      $page->save();

      $pageData = $page->PageData;
      $pageData->heading = $request->input('txtPageName');
      $pageData->content = $request->input('txtPageContent');

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
        $videoPath = Media::processMedia($videoInput, 'advert_video/');

        // If we have a valid image then set the path in the database
        if ($videoPath != null) {
          $pageData->video_path = $videoPath;
        }
      }

      $pageData->video_path = $request->input('txtPageVideo');

      $pageData->save();

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
