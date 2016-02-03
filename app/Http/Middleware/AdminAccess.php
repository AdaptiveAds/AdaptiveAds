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

      // Does user have permission to access this page?
      if ($user->getAdmin() == false && $super_user == false) {
        return response('Unauthorized.', 401);
      }

      return $next($request);

    }
}
