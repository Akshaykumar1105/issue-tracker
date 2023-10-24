<?php
namespace App\Services;

use App\Models\User;
use App\Models\Issue;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService {
    public function index(){
        $allMonths = range(1, 12);
        $currentMonth = Carbon::now()->month;
        $lastThreeMonths = range($currentMonth - 2, $currentMonth);
        $data = [
            'userCount' => User::whereNotNull('company_id')->count(),
            'issueCount' => Issue::count(),
            'companies' => Company::where('is_active', config('site.status.active'))->get(),
            'hrCount' => User::whereNull('parent_id')
                ->whereNotNull('company_id')
                ->selectRaw('MONTH(created_at) as month')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
            'managerCount' => User::whereNotNull('parent_id')
                ->selectRaw('MONTH(created_at) as month')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
        ];
        $userCount = $this->userCount($data, $lastThreeMonths);
        return compact('data', 'userCount');
    }

    public function getIssueStatusCount($companyId){
        $query = Issue::select('status')->selectRaw('COUNT(*) as count');
        if ($companyId && $companyId !== 'default') {
            $query->where('company_id', $companyId);
        }
        return $query->groupBy('status')->get();
    }

    private function userCount($data, $lastThreeMonths){
        $userCount = [
            'hrCount' => array_fill_keys($lastThreeMonths, 0),
            'managerCount' => array_fill_keys($lastThreeMonths, 0),
        ];

        foreach ($data['hrCount'] as $user) {
            if (!isset($userCount['hrCount'][$user->month])) {
                $userCount['hrCount'][$user->month] = array_fill_keys($lastThreeMonths, 0);
            }
            $userCount['hrCount'][$user->month] = $user->count;
        }

        foreach ($data['managerCount'] as $user) {
            if (!isset($userCount['managerCount'][$user->month])) {
                $userCount['managerCount'][$user->month] = array_fill_keys($lastThreeMonths, 0);
            }
            $userCount['managerCount'][$user->month] = $user->count;
        }

        return $userCount;
    }
}
?>