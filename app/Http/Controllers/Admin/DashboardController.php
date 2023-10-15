<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Issue;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = User::whereNotNull(['company_id'])->count();
        $issue = Issue::count();
        $company = Company::count();
        $issueStatusData = Issue::select('status')
            ->selectRaw('count(*) as count')
            ->groupBy('status')
            ->get();

        $hrData = User::whereNull('parent_id')->whereNotNull('company_id')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $managerData = User::whereNotNull('parent_id')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        return view('dashboard.dashboard', compact('user', 'issue', 'company', 'issueStatusData', 'hrData', 'managerData'));
    }
}
