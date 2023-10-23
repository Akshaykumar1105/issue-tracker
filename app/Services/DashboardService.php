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
                ->whereIn(DB::raw('MONTH(created_at)'), $lastThreeMonths)
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
            'managerCount' => User::whereNotNull('parent_id')
                ->selectRaw('MONTH(created_at) as month')
                ->selectRaw('COUNT(*) as count')
                ->whereIn(DB::raw('MONTH(created_at)'), $lastThreeMonths)
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
        ];

        $resultData = $this->userData($data, $lastThreeMonths);

        return compact('data', 'resultData');
    }

    public function getIssueStatusData($companyId){
        $query = Issue::select('status')->selectRaw('COUNT(*) as count');
        if ($companyId && $companyId !== 'default') {
            $query->where('company_id', $companyId);
        }
        return $query->groupBy('status')->get();
    }

    private function userData($data, $lastThreeMonths)
    {
        $resultData = [
            'hrCount' => array_fill_keys($lastThreeMonths, 0),
            'managerCount' => array_fill_keys($lastThreeMonths, 0),
        ];

        foreach ($data['hrCount'] as $user) {
            if (!isset($resultData['hrCount'][$user->month])) {
                $resultData['hrCount'][$user->month] = array_fill_keys($lastThreeMonths, 0);
            }
            $resultData['hrCount'][$user->month] = $user->count;
        }

        foreach ($data['managerCount'] as $user) {
            if (!isset($resultData['managerCount'][$user->month])) {
                $resultData['managerCount'][$user->month] = array_fill_keys($lastThreeMonths, 0);
            }
            $resultData['managerCount'][$user->month] = $user->count;
        }

        return $resultData;
    }
}
?>