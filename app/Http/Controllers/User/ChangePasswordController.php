<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePassword;

class ChangePasswordController extends Controller
{
    protected $authservice;

    public function __construct(AuthService $authservice){
        $this->authservice = $authservice;
    }

    public function index(){
        return view('auth.change-password');
    }

    public function update(ChangePassword $request){
        return $this->authservice->changePassword($request);
    }
}
