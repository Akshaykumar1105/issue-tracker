<?php

namespace App\Http\Controllers\Hr;

use App\Services\ManagerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Manager\Store;
use App\Http\Requests\User\Manager\Update;
use App\Http\Requests\User\ManagerCreate;
use App\Http\Requests\User\ManagerUpdate;
use App\Models\User;

class ManagerController extends Controller{
    protected $managerService;

    public function __construct(ManagerService $managerService){
        $this->managerService = $managerService;
    }
    
    public function index(Request $request){
        if ($request->ajax()) {
            return $this->managerService->collection($companyId = null,$request);
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
