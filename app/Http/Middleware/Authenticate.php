<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Session;
use Auth;
use App\User as User;

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

        //$privilages = $departments->first()->pivot->privilage;

        // Get users departments and privilages
        $user = Auth::user()->with('Departments.Location')
                            ->with('Departments.Screen')
                            ->with('Departments.Skin')
                            ->where('User.id', Auth::id())->first();

        $user_departments = $user->Departments;
        $allowed_departments = [];
        foreach ($user_departments as $department) {
          array_push($allowed_departments, $department);
        }

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
