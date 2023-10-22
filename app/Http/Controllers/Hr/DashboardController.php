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
        $data = [
            'manager' => User::where('company_id', $user->company_id)->where('parent_id', $user->id)->count(),
            'issue' => Issue::where('hr_id', $user->id)->count()
        ];
        return view('hr.dashboard.index', ['data' => $data]);
    }
}
