<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthService;
use App\Models\PasswordResetToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPassword;

class ResetPasswordController extends Controller
{
    protected $authservice;

    public function __construct(AuthService $authservice){
        $this->authservice = $authservice;
    }
    
    public function index($token){
        return $this->authservice->resetPassword($token);
    }

    public function update(ResetPassword $request){
       return $this->authservice->updateResetPassword($request);
    }
}
