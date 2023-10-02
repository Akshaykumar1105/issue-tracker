<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ManagerService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\User\Manager\Store;
use App\Http\Requests\User\ManagerCreate;
use App\Http\Requests\User\ManagerUpdate;
use App\Http\Requests\User\Manager\Update;


class ManagerController extends Controller{
    protected $managerService;

    public function __construct(ManagerService $managerService){
        $this->managerService = $managerService;
    }
    
    public function index(Request $request){
        if ($request->ajax()) {
            $data = $this->managerService->collection($companyId =null, $request);
            return DataTables::of($data)->with('media')->addIndexColumn()
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->addColumn('profile', function ($row) {
                $user = User::find($row->id);
                $media = $user->firstMedia('user');
                $img = asset('storage/user/' . $media->filename . '.' . $media->extension);
                $profile = '<img class="image--cover" src=' . $img . ' />';
                return $profile;
            })
            ->addColumn('action', function ($row, Request $request) {
                $editRoute = route('hr.manager.edit', ['manager' => $row->id]);
                if ($request->listing == 'manager') {
                    $actionBtn = '<p>No Action</p>';
                    return $actionBtn;
                }
                else{
                    $actionBtn = '<a href=' . $editRoute . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="edit btn btn-success btn-sm">Edit</a> <button type="submit" data-userId="' . $row->id . '" class="delete btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#deleteManager">Delete</button>';
                    return $actionBtn;
                }
            })
            ->rawColumns(['profile', 'action'])
            ->make(true);
        }
        return view('hr.manager.index');
    }

    public function create(){
        return view('hr.manager.create');
    }

    public function store(Store  $request){
       return $this->managerService->store($request);
    }

    public function edit(User $manager){
        return view('hr.manager.create', ['manager' => $manager]);
    }

    public function update(Update $request,int $manager){
        return $this->managerService->update($request, $manager);
    }

    public function destroy(Request $request){
        
        return $this->managerService->destroy($request);
    }
}
