<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\User\IssueService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Issue\Store;
use App\Services\User\UserService;

class UserController extends Controller{

    protected $issueService;

    public function __construct(IssueService $issueService)
    {
        $this->issueService = $issueService;
    }

    public function index(Request $request){
        if($request->ajax()){
           return  $this->issueService->index($request);
        }
        $company = Company::where('is_active', '1')->get();
        return view('user.home', ['companies' => $company, 'hrs' => $user ?? null]);
    }

    public function store(Store $request){
        return $this->issueService->store($request);
    }
}
