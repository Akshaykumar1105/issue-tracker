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
            return $this->userService->collection($request);
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
