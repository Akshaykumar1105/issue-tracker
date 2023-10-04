<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Issue\Store;
use App\Models\Company;
use App\Models\User;
use App\Services\IssueService;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    protected $issueService;

    public function __construct(IssueService $issueService)
    {
        $this->issueService = $issueService;
    }

    public function index(Request $request){
        // dd($request->uuid);
        $company = Company::where('uuid', $request->company)->first(); 
        $hr = User::where('company_id', $company->id)->whereNull('parent_id')->get();
        if($company){
            $uuid = $company->uuid;
            return view('user.issue.create', ['uuid' => $uuid, 'hrs' => $hr ?? null]);
        }
        return abort(404);

    }

    public function store(Store $request){
        return $this->issueService->store($request);
    }
}
