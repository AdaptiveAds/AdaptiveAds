<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Session;
use Auth;
use App\User as User;
use App\Department as Department;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If a guest redirect
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }

        // TODO put somewhere else!!!!!
        // Get users departments and privilages
        $user = Auth::user()->with('departments')
                            ->where('user.id', Auth::id())->first();

        $allowed_departments = [];
        $admin_departments = [];

        // If super user allow access to all departments
        if ($user->is_super_user) {
          $user_departments = Department::all();
          // TODO DISABLE
          $user->setAdmin(true);
        } else {
          $user_departments = $user->Departments;

          /*foreach ($user_departments as $department) {
            //array_push($admin_departments, $department);

            // Check if the user is an admin in the department
            if ($user->isAdmin($department->id)) {
              //dd($department->id);
              $user->setAdmin(true);
              //array_push($admin_departments, $department);

              $bin = $user_departments->pull($department->id);
              dd($bin->id);
              array_push($admin_departments, $bin);
            }*/

            /*dd($user->GetAdminDepartments());

            $admin_departments = $user_departments->filter(function($item) use ($user) {
              return $user->isAdmin($item->id);
            })->values();
          //}

          dd($admin_departments);*/
        }

        // transfer collection to array
        foreach ($user_departments as $department) {
          array_push($allowed_departments, $department);

          // Check if the user is an admin in the department
          if ($user->isAdmin($department->id)) {
            $user->setAdmin(true);
          }
        }

        // Get an array of id's of all departments this user can access
        $match_departments = [];
        foreach ($allowed_departments as $department) {
          array_push($match_departments, $department->id);
        }

        // Save until next request
        Session::flash('user', $user);
        Session::flash('allowed_departments', $allowed_departments);
        Session::flash('match_departments', $match_departments);
        //dd($user);

        return $next($request);
    }
}
