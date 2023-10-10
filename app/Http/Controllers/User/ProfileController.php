<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Update;
use App\Services\HrService;
use App\Services\UserService;

// use MediaUploader;

class ProfileController extends Controller{
    protected $userService;

    public function __construct(HrService $userService){
        $this->userService = $userService;
    }

    public function index(){
        $user = auth()->user();
        return view('dashboard.profile', ['user' => $user]);
    }

    public function update(Update $request, $id){
        return $this->userService->update($request, $id);
    }
}