<?php

namespace App\Http\Controllers\Hr;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Hr\Store;
use App\Services\HrService;

class HrController extends Controller
{
    protected $userService;

    public function __construct(HrService $userService){
        $this->userService = $userService;
    }
    
    public function create(){
        if (!auth()->user()->hasRole(config('site.role.admin'))) {
            return redirect()->route('home');
        }
        $company = Company::where('is_active', 1)->get();
        return view('front.hr.create', ['companies' => $company]);
    }

    public function store(Store $request){
        return $this->userService->store($request);
    }
}
