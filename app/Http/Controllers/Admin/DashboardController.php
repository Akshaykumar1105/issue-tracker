<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Issue;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke(){
        $user = User::whereNotNull(['company_id'])->count();
        $issue = Issue::count();
        $company = Company::count();
        return view('dashboard.dashboard', ['user' => $user, 'issue' => $issue, 'company' => $company]);
    }
}
