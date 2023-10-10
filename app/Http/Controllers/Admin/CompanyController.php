<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Services\HrService;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Services\ManagerService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\Company\Store;
use App\Http\Requests\Admin\Company\Update;


class CompanyController extends Controller{

    protected $companyService;
  

    public function __construct(CompanyService $companyService){
        $this->companyService = $companyService;
       
    }

    public function index(Request $request){
        if ($request->ajax()) {
            if($request->listing){
                return $this->companyService->collection($companyId = null, $request);
            }
            $query = Company::select('id', 'name', 'email', 'number', 'address', 'is_active', 'created_at');
            return DataTables::of($query)
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('action', function ($row) {
                    $edit = route('admin.company.edit', ['company' => $row->id]);
                    $hr = route('admin.hr.index', ['company_id' => $row->id]);
                    $manager = route('admin.manager.index', ['company_id' => $row->id]);
                    $actionBtn = '<div class="d-flex" style="flex-direction: column;justify-content: initial;align-items: baseline;gap: 10px;"><div><a href=' . $edit . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="edit btn btn-success btn-sm">Edit</a> <button type="submit" data-userId="' . $row->id . '" class="delete btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteCompany">Delete</button></div> <div><a href=' . $hr . ' id="viewHr' . $row->id . '" data-userId="' . $row->id . '" class="hr btn btn-primary btn-sm">View Hr</a> <a href=' . $manager . ' type="submit" data-userId="' . $row->id . '"  class="manager btn btn-primary btn-sm">View Manager</a></div></div>';
                    return $actionBtn;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.company.index');
    }

    public function create(){
        return view('admin.company.create');
    }

    public function store(Store $request){
        return $this->companyService->store($request);
    }

    public function show($companyId, Request $request){
        if ($request->ajax()) {
            return $this->companyService->collection($companyId, $request);
        }
        return view('admin.company.show', ['company' => $companyId]);
    }

    public function edit(Company $company){
        return view('admin.company.create', ['company' =>  $company]);
    }

    public function update(Update $request, Company $company){
        return $this->companyService->update($request, $company);
    }

    public function destroy(){
        return  $this->companyService->destroy();
    }
}
