<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $loginPath = 'login';
    protected $redirectPath = 'dashboard';
    protected $username = 'username';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'username' => 'required|max:255|unique:user',
            //'email' => 'required|email|max:255|unique:user',
            'password' => 'required|confirmed|min:6',
        ]);


        return Redirect::to('register')
          ->withErrors($validator) // send back all errors to the login form
          ->withInput(Input::except('password'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            //'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    public function getLogin()
    {
      $data = array(
        'pageID' => 'login'
      );

      return view('pages/login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        // get our login input
        $login = $request->input('login');

        // check login field
        $login_type = filter_var( $login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
        // merge our login field into the request with either email or username as key
        $request->merge([ $login_type => $login ]);
        // let's validate and set our credentials
        if ( $login_type == 'email' ) {
            $this->validate($request, [
                'email'    => 'required|email',
                'password' => 'required',
            ]);
            $credentials = $request->only( 'email', 'password' );
        } else {
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ]);
            $credentials = $request->only( 'username', 'password' );
        }
        if ($this->auth->attempt($credentials, $request->has('remember')))
        {
            return redirect()->intended($this->redirectPath());
        }
        
        return redirect($this->loginPath())
            ->withInput($request->only('login', 'remember'))
            ->withErrors([
                'login' => $this->getFailedLoginMessage(),
            ]);
    }

    public function getRegister()
    {
      $data = array(
        'pageID' => 'register'
      );

      return view('pages/register');
    }
}
