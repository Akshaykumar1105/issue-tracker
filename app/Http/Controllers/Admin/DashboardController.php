<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Issue;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;
    public function __construct(DashboardService $dashboardService){
     $this->dashboardService = $dashboardService;   
    }

    public function index(){
        $dashboardData = $this->dashboardService->index();
        return view('dashboard.dashboard', $dashboardData);
    }

    public function issueChart(Request $request)
    {
        if ($request->ajax()) {
            $companyId = $request->companyId;
            $issueStatusData = $this->dashboardService->getIssueStatusData($companyId);
            return $issueStatusData;
        }
    }
}
