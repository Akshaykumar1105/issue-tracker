<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Manager\Store;
use App\Http\Requests\User\Manager\Update;
use App\Models\Company;
use App\Models\User;
use App\Services\ManagerService;
use Yajra\DataTables\Facades\DataTables;


class ManagerController extends Controller{

    protected $managerService;

    public function __construct(ManagerService $managerService){
        $this->managerService = $managerService;
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $query = $this->managerService->collection($companyId = null,$request);
            return DataTables::eloquent($query)
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addIndexColumn()
                ->addColumn('profile', function ($row) {
                    $user = User::find($row->id);
                    $media = $user->firstMedia('user');
                    $img = asset('storage/user/' . $media->filename . '.' . $media->extension);
                    $profile = '<div style=" padding: 20px; width: 40px; height: 40px; background-size: cover; background-image: url(' . $img . ');" class="img-circle elevation-2" alt="User Image"></div>';
                    return $profile;
                })
                ->addColumn('action', function ($row) {
                    $manager = $row->id;
                    $editManager = route('admin.manager.edit', ['manager' => $manager]);
                    $actionBtn = '<div class="d-flex" style="flex-direction: column;justify-content: initial;align-items: baseline;gap: 10px;"><div><a href=' . $editManager . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt" style="margin: 0 5px 0 0"></i>Edit</a> <button type="submit" data-user-id="' . $row->id . '" class="delete btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#deleteUser"><i class="fas fa-trash" style="margin: 0 5px 0 0;"></i>Delete</button></div></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'profile'])
                ->make(true);
        }
        $company = Company::where('is_active', config('site.status.active'))->get();
        $hrs = User::whereNull('parent_id')->whereNotNull('company_id')->get();
        return view('admin.user.index', ['companies' => $company, 'hrs' => $hrs]);
    }

    public function create(Request $request){
        $companies = Company::where('is_active', config('site.status.active'))->get();
        $hrs = User::whereNotNull('company_id')->whereNull('parent_id')->get();
        if($request->ajax()){
           $hr = User::where('company_id', $request->company)->whereNull('parent_id')->get();
           return $hr;
        }
        return view('admin.user.create', compact('companies', 'hrs'));
    }

    public function store(Store $request){
        return $this->managerService->store($request);
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $companies = Company::where('is_active', config('site.status.active'))->get();
        return view('admin.user.create', ['companies' => $companies, 'user' => $user]);
    }

    public function update($id, Update $request){
        return $this->managerService->update($id,$request);
    }

    public function destroy($id){
        return $this->managerService->destroy($id);
    }

}
