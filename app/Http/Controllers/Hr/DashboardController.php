<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Issue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        $issueStatus = Issue::where('hr_id', $user->id)->select('status')->selectRaw('COUNT(*) as count')->groupBy('status')->get();
        $data = [
            'managerCount' => User::where('company_id', $user->company_id)->where('parent_id', $user->id)->count(),
            'issueCount' => Issue::where('hr_id', $user->id)->count(),
        ];
        return view('hr.dashboard', ['data' => $data, 'issueStatus' => $issueStatus]);
    }
}
