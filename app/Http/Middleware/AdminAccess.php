<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

      $user = Session::get('user');
      $super_user = Session::get('super_user');

      // Get the users allowed departmentments
      // includes both admin and user access/permission
      $allowed_departments = Session::get('allowed_departments');
      $match_departments = Session::get('match_departments');
      $admin_departments = [];
      $admin_match_departments = [];

      // Does user have permission to access this page?
      if ($super_user == false) {
        if ($user->getAdmin() == false) {
          return response('Unauthorized.', 401);
        } else{
          // Only allow those defined by the database
          foreach ($allowed_departments as $department) {
            if ($department->getAdmin() == true) {
              array_push($admin_departments, $department);
              array_push($admin_match_departments, $department->id);
            }
          }
        }
      } else {
        $admin_departments = $allowed_departments;
        $admin_match_departments = $match_departments;
      }

      // Save an array of the departments that this user has
      // admin permissions to access
      Session::flash('allowed_departments', $admin_departments);
      Session::flash('match_departments', $admin_match_departments);

      return $next($request);

    }
}
