<?php

namespace App\Http\Controllers\User;

use App\Services\HrService;
use App\Services\ProfileService;
use App\Http\Requests\User\Update;
use App\Http\Requests\User\Profile;
use App\Http\Controllers\Controller;

class ProfileController extends Controller{
    protected $profileService;

    public function __construct(ProfileService $profileService){
        $this->profileService = $profileService;
    }

    public function index(){
        $user = auth()->user();
        return view('dashboard.profile', ['user' => $user]);
    }

    public function update(Profile $request, $id){
        return $this->profileService->update($request, $id);
    }
}