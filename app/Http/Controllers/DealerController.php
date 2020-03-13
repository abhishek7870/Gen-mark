<?php

namespace App\Http\Controllers;

use App\Dealer;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use Config;
use Carbon\Carbon;
use App\Code;
class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dealers = Dealer::all();
        return response()->json($dealers->load('companies'),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'first_name'     => 'required',
            'last_name'      => 'required',
            'email'          => 'required|email|unique:dealers,email',
            'phone_no'       => 'required|unique:dealers,phone_no',
            'gst_no'         => 'required',
            'state_id'       => 'required|exists:states,id',
            'city'           => 'required'
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
            return response()->json($errors,400);
        }
        $dealer = Dealer::create($request->all());
        return response()->json($dealer,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dealer = Dealer::find($id);
        if($dealer)
        {
           return response()->json($dealer,201);
        }
        return response()->json(['error'=>'dealer not found']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function edit(Dealer $dealer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dealer $dealer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dealer $dealer)
    {
        //
    }
    public function signIn(Request $request) {
        $validation = Validator::make($request->all(), [
            'phone_no' => 'required',
            'otp' => 'required'
        ]);
        if ($validation->fails()) {
            $errors = $validation->errors();
            return response()->json($errors, 400);
        }
        $dealer = Dealer::authenticateDealer($request['phone_no']);
        if ($dealer) {
            $code = $dealer->codes()->latest()->first();
            //dd($code);
            if($code->code == $request['otp']) {
                Code::destroy($code->id);
                Config::set('auth.providers.users.model', \App\Dealer::class);
                $customClaims = ['model_type' => 'dealer'];
                $token = JWTAuth::fromUser($dealer,$customClaims);
                JWTAuth::setToken($token);
                $data['token'] = 'Bearer ' . $token;
                $data['dealer'] = $dealer;
              //  $expiration = JWTAuth::getJWTProvider()->decode($token)['exp'];
                //$data['expiration'] = Carbon::createFromTimestamp($expiration)->timezone('Asia/Kolkata');
                return response()->json($data, 200);
            }
            else {
                return response()->json(['error'=>'Code Incorrect'],401);
            }
            
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request) { 
            // dd("sdfdsfks");
       // dd(JWTAuth::getToken());
      JWTAuth::invalidate(JWTAuth::getToken());
      return response()->json(true, 200);
    }
    public function login(Request $request)
    {
       // dd("fdnsdf");
        $validation = Validator::make($request->all(), [
            'phone_no' => 'required',
            
        ]);
        if ($validation->fails()) {
            $errors = $validation->errors();
            return response()->json($errors, 400);
        }
       $dealer = Dealer::where('phone_no',$request['phone_no'])->first();
       //dd($dealer);
       if($dealer) {
            sendSMS($dealer);
        return response()->json($dealer,201);
       }
       return response()->json(false,201); 
    }

    public function dealerVerifyProduct(Request $request)
    {
            $validation = Validator::make($request->all(),[
                 'code' => 'required',
                 'company_id' => 'required',
                 'token' => 'required'
            ]);
            if($validation->fails())
            {
                $errors = $validation->errors();
                return response()->json($errors,400);
            }
            
    }
   public function authenticateDealer(Request $request)
       {  
          //dd(JWTAuth::parseToken());
         dd(JWTAuth::parseToken()->getPayload()->get('model_type')); 
           try {                
               if(!(JWTAuth::parseToken()->getPayload()->get('model_type') == 'dealer')) {
                   return response()->json(['error' => 'Token mismatch'], 400);
               }
               $id = JWTAuth::parseToken()->getPayload()->get('sub');
               $dealer  = Dealer::find($id);
               if(!$dealer){
                   return response()->json(['error' => 'dealer_not_found']);
               }
           } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
               return response()->json(['token_expired'], $e->getStatusCode());
           } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
               return response()->json(['token_invalid'], $e->getStatusCode());
           } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
               return response()->json(['token_absent'], $e->getStatusCode());
           }
           return response()->json($dealer,200);
       }
}
    