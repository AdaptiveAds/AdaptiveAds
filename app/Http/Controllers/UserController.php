<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Department as Department;
use App\User as User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

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
      $allowed_departments = Session::get('allowed_departments');

      $data = array(
        'pageID' => '',
        'allowed_departments' => $allowed_departments
      );

      return view('pages/users', $data);
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

    public function process(Request $request)
    {
      $allowed_departments = Session::get('allowed_departments');
      $user = Session::get('user');

      // Get input from request
      $btnFindUser = $request->input('btnFindUser');
      $btnFindAll = $request->input('btnFindAll');
      $username = $request->input('txtUsername');
      $departmentID = $request->input('drpDepartments');
      $users = null;

      //$privilage = $user->Departments()->where('id', $departmentID)->first()->pivot->Privilage;

      // Check which action to perform
      if (isset($btnFindUser)) {

        if ($user->isAdmin($departmentID)) {
          // Get users with a userame LIKE that of the input
          $users = User::where('username', 'LIKE', '%' . $username . '%')->get();

        } else {
          abort(401, 'Un-authorised');
        }

      } else if (isset($btnFindAll)) {

        if ($user->is_super_user) {
          // Get all users and clear the remembered search
          $username = null;
          $users = User::all();
        } else {
          abort(401, 'Un-authorised');
        }

      } else {
        abort(401, 'Un-authorised');
      }

      $data = array(
        'pageID' => '',
        'users' => $users,
        'username' => $username,
        'allowed_departments' => $allowed_departments
      );

      return view('pages/users', $data);
    }
}
