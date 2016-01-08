<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Page as Page;
use App\PageData as PageData;

class PageController extends Controller
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
        // NOTE not used
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
          'pageID' => 'pageeditor',
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
          'pageName' => 'required|max:255',
          'pageImage' => 'max:255',
          'pageVideo' => 'max:255',
          'pageContent' => 'max:255',
          //'pageIndex' => 'unique:page'
      ]);

      // Was validation successful?
      $pageData = new PageData;

      $pageData->page_data_name = $request->input('pageName');
      $pageData->page_image = $request->input('pageImage');
      $pageData->page_video = $request->input('pageVideo');
      $pageData->page_content = $request->input('pageContent');
      $pageData->save();

      $page = new Page;
      $page->page_data_id = $pageData->id;
      $page->page_index = $request->input('pageIndex');
      $page->advert_id = $adID;
      $page->vertical_id = 2;
      $page->horizontal_id = 2;
      $page->save();

      $data = array(
        'pageID' => 'pageeditor',
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
      $page = Page::find($id);
      $pageData = $page->PageData;

      $data = array(
        'pageID' => 'pageeditor',
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
          'pageName' => 'required|max:255',
          'pageImage' => 'max:255',
          'pageVideo' => 'max:255',
          'pageContent' => 'max:255',
          //'pageIndex' => 'unique:page'
      ]);

      $page = Page::find($id);
      $page->page_index = $request->input('pageIndex');
      $page->vertical_id = 1;
      $page->horizontal_id = 1;
      $page->save();

      $pageData = $page->PageData;
      $pageData->page_data_name = $request->input('pageName');
      $pageData->page_image = $request->input('pageImage');
      $pageData->page_video = $request->input('pageVideo');
      $pageData->page_content = $request->input('pageContent');
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
}
