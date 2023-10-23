<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\Company\Store;
use App\Http\Requests\Admin\Company\Update;

class CompanyController extends Controller
{

    protected $companyService;


    public function __construct(CompanyService $companyService){
        $this->companyService = $companyService;
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $query = $this->companyService->collection();
            return DataTables::of($query)
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('action', function ($row) {
                    $edit = route('admin.company.edit', ['company' => $row->id]);
                    $hr = route('admin.hr.index', ['company_id' => $row->id]);
                    $manager = route('admin.manager.index', ['company_id' => $row->id]);
                    $actionBtn = '<div class="d-flex" style="flex-direction: column;justify-content: initial;align-items: baseline;gap: 10px;"><div><a href=' . $edit . ' id="edit' . $row->id . '" data-user-id="' . $row->id . '" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt" style="margin: 0 5px 0 0">
                    </i>Edit</a> <button type="submit" data-user-id="' . $row->id . '" class="delete btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteCompany"> <i class="fas fa-trash" style="margin: 0 5px 0 0;">
                </i>Delete</button></div> <a href=' . $hr . ' id="viewHr' . $row->id . '" data-user-id="' . $row->id . '" class="hr btn btn-primary btn-sm"> <i class="fa-solid fa-eye" style="margin:0 5px 0 0"></i>View Hr</a> <a href=' . $manager . ' type="submit" data-user-id="' . $row->id . '"  class="manager btn btn-primary btn-sm"><i class="fa-solid fa-eye" style="margin:0 5px 0 0"></i>View Manager</a></div>';
                    return $actionBtn;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.company.index');
    }

    public function create(){
        $cities = City::get();
        return view('admin.company.create', ['cities' => $cities]);
    }

    public function store(Store $request){
        return $this->companyService->store($request);
    }

    public function edit(Company $company){
        $cities = City::get();
        return view('admin.company.create', ['company' =>  $company, 'cities' => $cities]);
    }

    public function update(Update $request, Company $company){
        return $this->companyService->update($request, $company);
    }

    public function destroy($id){
        return  $this->companyService->destroy($id);
    }
}
