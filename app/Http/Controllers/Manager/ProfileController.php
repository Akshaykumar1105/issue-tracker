<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\HrService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(HrService $userService){
        $this->userService = $userService;
    }

    public function index(){
        $user = auth()->user();
        return view('dashboard.profile', ['user' => $user]);
    }

    public function update(Request $request){
        return $this->userService->update($request);
    }
}
