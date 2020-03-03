<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Http\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Dealer;
use Tymon\JWTAuth\Http\Exceptions\TokenExpiredException;

class ValidateDealerToken extends BaseMiddleware
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
        // dd("hello");
        // dd($this->auth->setRequest($request)->getToken());
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
        }
        try {
            $user_type = JWTAuth::parseToken()->getPayload()->get('model_type');
             
            $payload = JWTAuth::getPayload($token)->get('sub');
             // dd($payload);   
            // AS : Allow Only Evaluator's token to be validated
            if($payload) {
                $id = $payload;
               // dd($id);
                $dealer = Dealer::find($id);
                if($dealer) {
                    return $next($request);
                }
                return response()->json(['error' => 'Evaluator_not_found'], 404);
            }
            else 
            {
                return response()->json(['Token Mismatch'], 400);
            }
          
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token Expired'], 400);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid JWT token'], 400);
        }
        if (! $dealer) {
            return response()->json(['tymon.jwt.user_not_found', 'evaluator_not_found'], 404);
        }
        return $next($request);
    }
}
