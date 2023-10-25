<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Company;
use App\Services\HrService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Hr\Store;
use App\Http\Requests\User\Hr\Update;
use Yajra\DataTables\Facades\DataTables;

class HrController extends Controller
{

    protected $hrService;

    public function __construct(HrService $hrService)
    {
        $this->hrService = $hrService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->hrService->collection($companyId = null, $request);
            return DataTables::eloquent($query)
                ->orderColumn('DT_RowIndex', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addIndexColumn()
                ->addColumn('profile', function ($row) {
                    $user = User::find($row->id);
                    $media = $user->firstMedia('user');
                    if($media){
                        $img = asset('storage/user/' . $media->filename . '.' . $media->extension);
                    }
                    else{
                        $img = asset('storage/user/user.png');
                    }
                    $profile = '<div style=" padding: 20px; width: 40px; height: 40px; background-size: cover; background-image: url(' . $img . ');" class="img-circle elevation-2" alt="User Image"></div>';
                    return $profile;
                })

                ->addColumn('action', function ($row) {
                    $user = $row->id;
                    $showManager = route('admin.manager.index', ['company_id' => $row->company_id, 'hr_id' => $user]);
                    $editHr = route('admin.hr.edit', ['hr' => $user]);
                    $actionBtn = '<div class="d-flex" style="flex-direction: column;justify-content: initial;align-items: baseline;gap: 10px;"><div><a href=' . $editHr . ' id="edit' . $row->id . '" data-user-id="' . $row->id . '" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt" style="margin: 0 5px 0 0"></i>Edit</a> <button type="submit" data-userId="' . $row->id . '" class="delete btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#deleteUser"><i class="fas fa-trash" style="margin: 0 5px 0 0;"></i>Delete</button></div><a href="' . $showManager . '" id="edit' . $row->id . '" data-userId="' . $row->id . '" class="view btn btn-primary btn-sm"><i class="fa-solid fa-eye" style="margin:0 5px 0 0"></i>View Manager</a></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'profile'])
                ->make(true);
        }
        $companies = Company::where('is_active', config('site.status.active'))->get();
        return view('admin.user.index', ['companies' => $companies]);
    }

    public function create(){
        $companies = Company::where('is_active', config('site.status.active'))->get();
        return view('admin.user.create', ['companies' => $companies]);
    }

    public function store(Store $request){
        return $this->hrService->store($request);
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $companies = Company::where('is_active', config('site.status.active'))->get();
        return view('admin.user.create', ['companies' => $companies, 'user' => $user]);
    }

    public function update($id, Update $request){
        return $this->hrService->update($id, $request);
    }

    public function destroy($id){
        return $this->hrService->destroy($id);
    }
}
