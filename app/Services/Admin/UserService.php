<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Services\HrService;
use App\Services\ManagerService;
use Yajra\DataTables\Facades\DataTables;


class UserService
{

    protected $hrService;
    protected $managerService;

    public function __construct(HrService $hrService, ManagerService $managerService)
    {
        $this->hrService = $hrService;
        $this->managerService = $managerService;
    }

    public function collection($request){
        if ($request->listing == config('site.role.hr')) {
            if ($request->ajax()) {
                return $this->hrService->collection($companyId = null, $request);
            }
        }
        return $this->managerService->collection($companyId = null, $request);
    }

    public function recourse($request, $manager)
    {
        $query = User::where('parent_id', $manager->id)->select('id', 'name', 'email')->get();
        return DataTables::of($query)->make(true);
    }
}
