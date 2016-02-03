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

        // Get users departments and privilages
        $user = Auth::user()->with('departments')
                            ->where('user.id', Auth::id())->first();

        // If super user allow access to all departments
        if ($user->is_super_user) {
          $user_departments = Department::all();
        } else {
          $user_departments = $user->Departments;
        }

        // transfer collection to array
        $allowed_departments = [];
        foreach ($user_departments as $department) {
          array_push($allowed_departments, $department);
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
