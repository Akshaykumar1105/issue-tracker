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

    public function index(Request $request)
    {
        $uuid = $request->input('company');

        $company = Company::where('uuid', $uuid)->first();

        if (!$company) {
            return abort(404);
        }

        $hrs = User::where('company_id', $company->id)
            ->whereNull('parent_id')
            ->get();

        return view('user.issue.create', compact('uuid', 'hrs'));
    }

    public function store(Store $request)
    {
        return $this->issueService->store($request);
    }
}
