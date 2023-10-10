<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPassword;
use App\Services\AuthService;


class ForgetPasswordController extends Controller{
    protected $authservice;

    public function __construct(AuthService $authservice){
        $this->authservice = $authservice;
    }
    
    public function index(){
        return view('auth.forgot-password');
    }

    public function store(ForgetPassword $request){
        return $this->authservice->forgetPassword( $request);
    }
}
