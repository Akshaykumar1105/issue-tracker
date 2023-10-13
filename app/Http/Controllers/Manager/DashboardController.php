<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\Request;

class DashboardController extends Controller{
    public function __invoke(){
        $user =auth()->user();
        $issue = Issue::where('manager_id', $user->id)->count();
        return view('dashboard.dashboard', ['issue' => $issue]);
    }
}
