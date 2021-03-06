<?php

namespace App\Http\Middleware;
use App\User;
use Closure;

class APIToken
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
        if ($request->header('Authorization')) {
            
            $user = User::where('api_token',$request->header('Authorization'))->first();
            if ($user) {
                return $next($request);
            }
        }
        return response()->json([
            'message' => 'Not a valid API request.',
            'data'=> [],
            'status' => 401
        ],200);
        
    }
}
