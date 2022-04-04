<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    private $apiToken;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
         // Unique Token
         $this->apiToken = uniqid(base64_encode(Str::random(60)));
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request)
    {
        $user = User::where('email',strtolower($request->email))->first();  

        if ($user) {
            
            if ( password_verify($request->password, $user->password) ) {
                
                $token = ['api_token' => $this->apiToken];

                $login = User::where('id', $user->id)->update($token);

                if ($login) {

                    $user = $user->fresh();

                    return response()->json([
                        'message' => 'User logged',
                        'data'=>$user,
                        'status' => 200
                    ],200);
                }
            }else {
                return response()->json([
                    'message' => 'password invalid',
                    'data'=> [],
                    'status' => 401
                ],200);
            }
        }else{
            return response()->json([
                'message' => 'email invalid',
                'data'=> [],
                'status' => 401
            ],200);
        }
      
    }
}
