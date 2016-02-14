<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Input;

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
        'user' => $user,
        'allowed_departments' => $allowed_departments
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
        // TODO VALIDATION

        $txtTemplateName = $request->input('txtTemplateName');
        $txtTemplateClass = $request->input('txtTemplateClass');
        $numTemplateDuration = $request->input('numTemplateDuration');

        $template = new Template();
        $template->name = $txtTemplateName;
        $template->class_name = $txtTemplateClass;
        $template->duration = $numTemplateDuration;

        // Upload image 1
        $imageInput = Input::file('filTemplateThumbnail');
        if ($imageInput != null) {
          $imagePath = Images::processImage($imageInput, 'template_thumbmails');

          // If we have a valid image then set the path in the database
          if ($imagePath != null) {
            $template->thumbnail = $imagePath;
          }
        }

        $template->save();

        return redirect()->route('dashboard.settings.templates.index');
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

      $template = Template::find($id);
      if ($template == null)
        abort(404, 'Not found.');

      return array('template' => $template);
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
        $template = Template::find($id);

        if ($template != null) {

          $txtTemplateName = $request->input('txtTemplateName');
          $txtTemplateClass = $request->input('txtTemplateClass');
          $numTemplateDuration = $request->input('numTemplateDuration');

          $template->name = $txtTemplateName;
          $template->class_name = $txtTemplateClass;
          $template->duration = $numTemplateDuration;

          // Upload image 1
          $imageInput = Input::file('filTemplateThumbnail');
          if ($imageInput != null) {
            $imagePath = Images::processImage($imageInput, 'template_thumbmails');

            // If we have a valid image then set the path in the database
            if ($imagePath != null) {
              $template->thumbnail = $imagePath;
            }
          }

          $template->save();


        } else {
          abort(404, 'Not found.');
        }

        return redirect()->route('dashboard.settings.templates.index');
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
