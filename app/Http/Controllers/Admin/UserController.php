<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Company;
use App\Services\HrService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Hr\Update;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
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
                    $user = $row->id;
                    $showManager = route('admin.manager.index', ['company_id' => $row->company_id, 'hr_id' => $user]);
                    $editHr = route('admin.hr.edit', ['hr' => $user]);
                    $actionBtn = '<div class="d-flex" style="flex-direction: column;justify-content: initial;align-items: baseline;gap: 10px;"><div><a href=' . $editHr . ' id="edit' . $row->id . '" data-user-id="' . $row->id . '" class="edit btn btn-success btn-sm">Edit</a> <button type="submit" data-userId="' . $row->id . '" class="delete btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#deleteUser">Delete</button></div><a href="' . $showManager . '" id="edit' . $row->id . '" data-userId="' . $row->id . '" class="view btn btn-primary btn-sm">View Manager</a></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'profile'])
                ->make(true);
        }
        $company = Company::where('is_active', config('site.status.active'))->get();
        return view('admin.user.index', ['companies' => $company]);
    }

    public function create(){
        $company = Company::where('is_active', config('site.status.active'))->get();
        return view('admin.user.create', ['companies' => $company]);
    }

    public function store(Request $request){
        return $this->hrService->store($request);
    }

    public function edit($id, Request $request){
        $user = User::findOrFail($id);
        $company = Company::where('is_active', config('site.status.active'))->get();
        return view('admin.user.create', ['companies' => $company, 'user' => $user]);
    }

    public function update($id, Update $request){
        return $this->hrService->update($id, $request);
    }

    public function destroy($id){
        return $this->hrService->destroy($id);
    }
}
