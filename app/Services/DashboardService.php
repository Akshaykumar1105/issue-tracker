<?php
namespace App\Services;

use App\Models\Company;
use App\Models\Issue;
use App\Models\User;

class DashboardService {
    public function index(){
        $allMonths = range(1, 12);

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

        $resultData = $this->userData($data, $allMonths);

        return compact('data', 'resultData');
    }

    public function getIssueStatusData($companyId)
    {
        $query = Issue::select('status')
            ->selectRaw('COUNT(*) as count');

        if ($companyId && $companyId !== 'default') {
            $query->where('company_id', $companyId);
        }

        return $query->groupBy('status')->get();
    }

    private function userData($data, $allMonths)
    {
        $resultData = [
            'user' => array_fill_keys($allMonths, 0),
            'hrCount' => array_fill_keys($allMonths, 0),
            'managerCount' => array_fill_keys($allMonths, 0),
        ];

        foreach ($data['hrCount'] as $user) {
            if (!isset($resultData['hrCount'][$user->month])) {
                $resultData['hrCount'][$user->month] = array_fill_keys($allMonths, 0);
            }
            $resultData['hrCount'][$user->month] = $user->count;
        }

        foreach ($data['managerCount'] as $user) {
            if (!isset($resultData['managerCount'][$user->month])) {
                $resultData['managerCount'][$user->month] = array_fill_keys($allMonths, 0);
            }
            $resultData['managerCount'][$user->month] = $user->count;
        }

        return $resultData;
    }
}
?>