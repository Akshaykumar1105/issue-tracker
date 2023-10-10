<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\UserService;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;


class ManagerController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $query = User::with('company')->whereNotNull('parent_id')->whereNotNull('company_id');
            if ($request->filter) {
                $query->where('company_id', $request->filter);
            }
            if ($request->hr) {
                $query->where('parent_id', $request->hr);
            }
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
                    // $showManager = route('admin.hr.show', ['manager' => $manager]);
                    $actionBtn = '<a href="#" id="edit' . $row->id . '" data-userId="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'profile'])
                ->make(true);
        }
        $company = Company::where('is_active', config('site.status.active'))->get();
        $hrs = User::whereNull('parent_id')->whereNotNull('company_id')->get();
        return view('admin.user.index', ['companies' => $company, 'hrs' => $hrs]);
    }
}
