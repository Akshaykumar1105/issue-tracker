<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\Admin\UserService;
use App\Services\HrService;
use App\Services\ManagerService;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller{

    protected $userService;
    protected $hrService;
    protected $managerService;

    public function __construct(UserService $userService, HrService $hrService, ManagerService $managerService){
        $this->userService = $userService;
        $this->hrService = $hrService;
        $this->managerService = $managerService;
    }


    public function index(Request $request){
        if($request->ajax()){
            $query = $this->userService->collection($request);
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('profile', function ($row) {
                    $user = User::find($row->id);
                    $media = $user->firstMedia('user');
                    $img = asset('storage/user/' . $media->filename . '.' . $media->extension);
                    $profile = '<div style=" padding: 20px; width: 40px; height: 40px; background-size: cover; background-image: url('.$img.');" class="img-circle elevation-2" alt="User Image"></div>';
                    return $profile;
                })
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('action', function ($row) {
                    $manager = $row->id;
                    $showManager = route('admin.user.show', ['manager' => $manager]);
                    $actionBtn = '<a href=' . $showManager . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'profile'])
                ->make(true);
        }
        $company = Company::where('is_active', config('site.status.active'))->get();
        return view('admin.user.index', ['companies' => $company]);
    }

    public function show(Request $request, User $manager){
        if ($request->ajax()) {
            return $this->userService->recourse($request, $manager);
        }
        return view('admin.user.show', ['manager' => $manager]);
    }
}
