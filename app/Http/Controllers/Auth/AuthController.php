<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\Auth\Login;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{

    protected $authservice;

    public function __construct(AuthService $authservice){
        $this->authservice = $authservice;
    }

    public function index(){
       if(auth()->user()){
        return redirect()->route('home');
       }
       return view('auth.login');
    }

    public function login(Login $request){
        return $this->authservice->login($request); 
    }

    public function logout(){
        return $this->authservice->logout(); 
    }
}
