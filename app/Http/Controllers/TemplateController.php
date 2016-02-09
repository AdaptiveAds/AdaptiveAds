<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Template as Template;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
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
      $match_departments = Session::get('match_departments');
      $allowed_departments = Session::get('allowed_departments');
      $user = Session::get('user');

      // Get templates that the user has access to
      //$templates = $this->getAllowedScreens($user, $allowed_departments);
      $templates = Template::all();

      //dd($allowed_screens);

      $data = array(
        'templates' => $templates,
        'user' => $user
      );

      return view('pages/templatesEditor', $data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function process(Request $request) {

      $user = Session::get('user');

      $btnAddTemplate = $request->input('btnAddTemplate');
      $btnFindTemplate = $request->input('btnFindTemplate');
      $btnFindAll = $request->input('btnFindAll');
      $templateName = $request->input('txtTemplateName');
      $templateClass = $request->input('txtTemplateClass');
      $templateDuration = $request->input('numTemplateDuration');

      if (isset($btnAddTemplate)) {

        $template = new Template();
        $template->name = $templateName;
        $template->class_name = $templateClass;
        $template->duration = $templateDuration;
        $template->save();

        $templateName = null;

      } else if (isset($btnFindTemplate)) {



      } else if (isset($btnFindAll)) {



      } else {
        abort(401, 'Un-authorised');
      }


      $data = array(
        'user' => $user,
        'templates' => $templates
      );

      return view('pages/templatesEditor', $data);
    }

    public function getAllowedTemplates($user, $allowed_departments) {



    }
}
