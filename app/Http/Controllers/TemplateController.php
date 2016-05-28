<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Input;

use App\Template as Template;
use App\Helpers\Helper as Helper;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
  * Defines the CRUD methods for the TemplateController
  * @author Josh Preece
  * @license REVIEW
  * @since 1.0
  */
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

      // Return all templates
      $templates = Template::all();

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
        $txtTemplateName = $request->input('txtTemplateName');
        $txtTemplateClass = $request->input('txtTemplateClass');
        $numTemplateDuration = $request->input('numTemplateDuration');

        $data = array(
          'txtTemplateName' => $txtTemplateName,
          'txtTemplateClass' => $txtTemplateClass,
          'numTemplateDuration' => $numTemplateDuration,
        );

        $rules = array(
          'txtTemplateName' => 'required|max:60|unique:template,name',
          'txtTemplateClass' => 'required|max:50|unique:template,class_name',
          'numTemplateDuration' => 'required|integer|min:1',
        );

        // Validate
        $reponse = Helper::validator($data,$rules,'dashboard.settings.templates.index');
        if (isset($reponse)) {
          return $reponse;
        }

        // Create new template
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

        // Save!
        $template->save();

        return redirect()->route('dashboard.settings.templates.index')
                         ->with('message', 'Template created successfully');
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

      // Load the selected template
      $template = Template::find($id);
      if ($template == null)
        return array('error' => 'Error: Template not found.');

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
      // NOTE not used
      return Response('Not found', 404);
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
        // Load selected templates
        $template = Template::find($id);

        if ($template == null)
          return redirect()->route('dashboard.settings.templates.index')
                           ->with('message', 'Error: Template not found');

        // Get request inputs
        $txtTemplateName = $request->input('txtTemplateName');
        $txtTemplateClass = $request->input('txtTemplateClass');
        $numTemplateDuration = $request->input('numTemplateDuration');

        $data = array(
          'txtTemplateName' => $txtTemplateName,
          'txtTemplateClass' => $txtTemplateClass,
          'numTemplateDuration' => $numTemplateDuration,
        );

        $rules = array(
          'txtTemplateName' => 'required|max:60|unique:template,name,'.$id,
          'txtTemplateClass' => 'required|max:50|unique:template,class_name,'.$id,
          'numTemplateDuration' => 'required|integer|min:1',
        );

        // Validate
        $reponse = Helper::validator($data,$rules,'dashboard.settings.templates.index');
        if (isset($reponse)) {
          return $reponse;
        }

        // Update
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

        // Update!
        $template->save();

        return redirect()->route('dashboard.settings.templates.index')
                         ->with('message', 'Templated updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id ID of the template to destroy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // Load selected template
      $template = Template::find($id);

      if ($template == null)
        return redirect()->route('dashboard.settings.templates.index')
                         ->with('message', 'Error: Template not found');

      // Check if any pages are hve this template assigned?
      $pagesCount = $template->Pages()->count();

      // Don't delete if template is referenced
      if ($pagesCount != 0)
        return redirect()->route('dashboard.settings.templates.index')
                         ->with('message', 'Unable to delete ' . $template->name .', as one or more pages require it.');

      // Delete
      $template->delete();

      return redirect()->route('dashboard.settings.templates.index')
                       ->with('message', 'Templete deleted successfully');
    }

    /**
      * Filter templates by criteria
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function filter(Request $request)
    {
      $user = Session::get('user');

      // Get request inputs
      $btnFindTemplate = $request->input('btnFindTemplate');
      $btnFindAll = $request->input('btnFindAll');
      $templateName = $request->input('txtTemplateName');
      $templateClass = $request->input('txtTemplateClass');
      $templateDuration = $request->input('numTemplateDuration');

      $templates = Template::all();

      // Check which action to perform
      if (isset($btnFindTemplate)) {

        $filtered = collect([]);

        // First filter by name
        if ($templateName != null) {
          $filtered = $templates->filter(function($item) use ($templateName) {
            if (strpos($item->name, $templateName) !== false) { // Get rough match
              return true;
            }
          });
        }

        // If no results found filter by class name
        if ($templateClass != null) {
          if ($filtered->count() == 0) {
            $filtered = $templates->filter(function($item) use ($templateClass) {
              if (strpos($item->class_name, $templateClass) !== false) { // Get rough match
                return true;
              }
            });
          }
        }

        // Again if no result found filter by duration
        if ($filtered->count() == 0) {
          $filtered = $templates->filter(function($item) use ($templateDuration) {
            if ($item->duration == $templateDuration) {
              return true;
            }
          });
        }

        $templates = $filtered;

      } else if (isset($btnFindAll)) {

        // Reset search fields
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
}
