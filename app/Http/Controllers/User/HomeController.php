<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\IssueService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Issue\Store;

class HomeController extends Controller{

    protected $issueService;

    public function __construct(IssueService $issueService)
    {
        $this->issueService = $issueService;
    }

    public function index(Request $request){
        if($request->ajax()){
           return  $this->issueService->index($request);
        }
        $company = Company::where('is_active', config('site.status.active'))->get();
        return view('front.home', ['companies' => $company, 'hrs' => $user ?? null]);
    }

    public function store(Store $request){
        return $this->issueService->store($request);
    }
}
