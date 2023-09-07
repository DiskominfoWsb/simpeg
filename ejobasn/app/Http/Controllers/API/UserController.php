<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Lcobucci\JWT\Parser;

class UserController extends Controller
{

    public $successStatus = 200;
    protected function guard()
    {
        return Auth::guard('api');
    }


    private $apiConsumer;
    private $auth;
    private $cookie;
    private $db;
    private $request;
    private $userRepository;

    public function __construct(Application $app) {
        $this->auth = $app->make('auth');
        $this->cookie = $app->make('cookie');
        $this->db = $app->make('db');
        $this->request = $app->make('request');
    }


    public function login(){
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('nAppDNTC')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role_id' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = \Input::all();
        $input['password'] = \Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('nAppDNTC')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['auth' => Auth::check(),'success' => $user], $this->successStatus);
    }

    public function logoutApi(Request $request)
    { 

        $cek = false;
        if (!$this->guard()->check()) {
            return response([
                'message' => 'No active user session was found'
            ], 404);
        }
        $token = $request->bearerToken();
        $id = (new Parser())->parse($token)->getHeader('jti');
        $revoked = \DB::table('oauth_access_tokens')->where('id',$id)->update(['revoked' => 1]);
        // $this->guard()->logout();
        Auth::logout();
        if($revoked){
            return response()->json(['success' => $revoked ,'message' => 'User was logged out'],$this->successStatus);
        }else{
            return response()->json(['success' => false ,'message' => 'Failed To Log Out'],500);
        }

    }    
}