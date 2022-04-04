<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }


    public function validateToken(Request $request){
        
        $token = $request->header('Authorization');    
        
        $user = User::where('api_token', $token)->first();
        if ($user) {
            return response()->json([
                'message' => 'User logged',
                'data'=>$user,
                'status'=>200
            ],200);
        }else{
            return response()->json([
                'message' => 'Unauthorized',
                'data'=> [],
                'status'=>401
            ],200);
        }
    }
}
