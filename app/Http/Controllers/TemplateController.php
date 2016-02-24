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
     * @param  int  $id ID of the template to show
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
     * @param  int  $id ID of the template to edit
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
     * @param  int  $id ID of the template to update
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
     * @param  int  $id ID of the template to destroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
      * Processes input from the screen. Includes basic filtering options
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function process(Request $request)
    {
      $user = Session::get('user');

      $btnFindTemplate = $request->input('btnFindTemplate');
      $btnFindAll = $request->input('btnFindAll');
      $templateName = $request->input('txtTemplateName');
      $templateClass = $request->input('txtTemplateClass');
      $templateDuration = $request->input('numTemplateDuration');

      $templates = Template::all();

      // Check which action to perform
      if (isset($btnFindTemplate)) {

        // First filter by name
        $filtered = $templates->filter(function($item) use ($templateName) {
          if ($item->name == $templateName) {
            return true;
          }
        });

        // If no results found filter by class name
        if ($filtered->count() == 0) {
          $filtered = $templates->filter(function($item) use ($templateClass) {
            if ($item->class_name == $templateClass) {
              return true;
            }
          });

          // Again if no result found filter by duration
          if ($filtered->count() == 0) {
            $filtered = $templates->filter(function($item) use ($templateDuration) {
              if ($item->duration == $templateDuration) {
                return true;
              }
            });
          }
        }

        $templates = $filtered;

      } else if (isset($btnFindAll)) {

        $templateName = null;
        $templateClass = null;
        $templateDuration = null;

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

    /**
      * Soft deletes a specified resource
      * @param int  $id ID of the template to soft delete
      * @return \Illuminate\Http\Response
      */
    public function toggleDeleted($id)
    {
      $template = Template::find($id);

      if ($template == null)
        abort(404, 'Not found.');

      if ($template->deleted == 0) {
        $template->deleted = 1;
      } else {
        $template->deleted = 0;
      }

      $template->save();

      return redirect()->route('dashboard.settings.templates.index');
    }
}
