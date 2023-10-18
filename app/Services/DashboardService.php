<?php
namespace App\Services;

use App\Models\Company;
use App\Models\Issue;
use App\Models\User;

class DashboardService {
    public function index(){
        $allMonths = range(1, 12);

        $data = [
            'user' => User::whereNotNull('company_id')->count(),
            'issue' => Issue::count(),
            'company' => Company::where('is_active', config('site.status.active'))->get(),
            'hrData' => User::whereNull('parent_id')
                ->whereNotNull('company_id')
                ->selectRaw('MONTH(created_at) as month')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
            'managerData' => User::whereNotNull('parent_id')
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
            'hrData' => array_fill_keys($allMonths, 0),
            'managerData' => array_fill_keys($allMonths, 0),
        ];

        foreach ($data['hrData'] as $user) {
            if (!isset($resultData['hrData'][$user->month])) {
                $resultData['hrData'][$user->month] = array_fill_keys($allMonths, 0);
            }
            $resultData['hrData'][$user->month] = $user->count;
        }

        foreach ($data['managerData'] as $user) {
            if (!isset($resultData['managerData'][$user->month])) {
                $resultData['managerData'][$user->month] = array_fill_keys($allMonths, 0);
            }
            $resultData['managerData'][$user->month] = $user->count;
        }

        return $resultData;
    }
}
?>