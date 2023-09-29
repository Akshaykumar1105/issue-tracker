<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Services\HrService;
use App\Services\ManagerService;
use Yajra\DataTables\Facades\DataTables;


class UserService{

    protected $hrService;
    protected $managerService;

    public function __construct(HrService $hrService, ManagerService $managerService){
        $this->hrService = $hrService;
        $this->managerService = $managerService;
    }

    public function collection($request){
        if($request->listing == config('site.role.hr')){
            if ($request->ajax()) {
                return $this->hrService->collection($companyId = null, $request);
            }
        }
        if ($request->ajax()) {
            return $this->managerService->collection($companyId = null, $request);
        }
        // if($request->listing == config('site.role.hr')){
        //     $query = User::with('company')->whereNull('parent_id')->whereNotNull('company_id');
            
        //     if ($request->filter) {
        //         $query->where('company_id', $request->filter);
        //     }
        //     return DataTables::of($query)
        //         ->orderColumn('name', function ($query, $order) {
        //             $query->orderBy('id', $order);
        //         })
        //         ->addColumn('action', function ($row) {
        //             $manager = $row->id;
        //             $showManager = route('admin.user.show', ['manager' => $manager]);
        //             $actionBtn = '<a href=' . $showManager . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
        //             return $actionBtn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        // else{
        //     $query = User::with('company')->whereNotNull('parent_id')->whereNotNull('company_id');
        //     // dd($query);
        //     if ($request->filter) {
        //         $query->where('company_id', $request->filter);
        //     }
        //     return DataTables::of($query)
        //         ->orderColumn('name', function ($query, $order) {
        //             $query->orderBy('created_at', $order);
        //         })
        //         ->addColumn('action', function ($row) {
        //             $manager = $row->id;
        //             $showManager = route('admin.user.show', ['manager' => $manager]);
        //             $actionBtn = '<a href=' . $showManager . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
        //             return $actionBtn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
    }

    public function recourse($request, $manager)
    {
        $query = User::where('parent_id', $manager->id)->select('id', 'name', 'email')->get();
        return DataTables::of($query)->make(true);
    }
}
