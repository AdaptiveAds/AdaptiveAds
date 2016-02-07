<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

use App\Page as Page;
use App\PageData as PageData;

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

      dd($request->input('txtPageImage_1'));

      $pageData->heading = $request->input('txtPageName');
      $pageData->video_path = $request->input('txtPageVideo');
      $pageData->content = $request->input('txtPageContent');

      // Upload image 1
      $imageInput = Input::file('filPageImage');
      if ($imageInput != null) {
        $imagePath = $this->processImage($imageInput);

        // If we have a valid image then set the path in the database
        if ($imagePath != null) {
          $pageData->image_path = $imagePath;
        }
      }

      $pageData->save();

      $page = new Page;
      $page->page_data_id = $pageData->id;
      $page->page_index = $request->input('NumPageIndex');
      $page->advert_id = $adID;
      $page->template_id = 1;
      $page->save();

      $data = array(
        'page' => $page
      );

      return redirect()->route('dashboard.advert.{adID}.page.show', [$adID, $page->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($adID, $id)
    {
      $match = ['id' => $id, 'deleted' => 0];
      $page = Page::where($match)->first(); // one to one only return 1
      $pageData = $page->PageData->where('id', $page->page_data_id)->orderBy('heading', 'ASC')->first();

      //dd($pageData);

      $data = array(
        'page' => $page,
        'pageData' => $pageData
      );

      return view('pages/pageeditor', $data);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $adID, $id)
    {

      // Validation
      $this->validate($request, [
          'txtPageName' => 'required|max:255',
      ]);

      $page = Page::find($id);
      $page->page_index = $request->input('NumPageIndex');
      $page->template_id = 1;
      $page->save();

      $pageData = $page->PageData;
      $pageData->heading = $request->input('txtPageName');
      $pageData->content = $request->input('txtPageContent');

      // Upload image 1
      $imageInput = Input::file('filPageImage');
      if ($imageInput != null) {
        $imagePath = $this->processImage($imageInput);

        // If we have a valid image then set the path in the database
        if ($imagePath != null) {
          $pageData->image_path = $imagePath;
        }
      }

      $pageData->video_path = $request->input('txtPageVideo');

      $pageData->save();

      return redirect()->route('dashboard.advert.{adID}.page.show', [$adID, $page->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($adID, $id)
    {
        $page = Page::find($id);

        $page->deleted = 1;
        $page->save();

        return redirect()->route('dashboard.advert.show', [$adID]);
    }

    /**
      * Takes an image upload, gives it a timestamp and moves it to advert_images in the public folder
      * @param \Illuminate\Http\Request\Input $input
      * @return string | null
      */
    public function processImage($input) {

      if ($input->isValid()) {
        $filename  = time() . '.' . $input->getClientOriginalExtension();

        $path = public_path('advert_images/');

        $input->move($path, $filename); // uploading file to given path

        return $filename;
      }

      return null;
    }
}
