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
use App\Models\City;

class CompanyController extends Controller
{

    protected $companyService;


    public function __construct(CompanyService $companyService){
        $this->companyService = $companyService;
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $query = $this->companyService->collection($companyId = null, $request);
            return DataTables::of($query)
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('action', function ($row) {
                    $edit = route('admin.company.edit', ['company' => $row->id]);
                    $hr = route('admin.hr.index', ['company_id' => $row->id]);
                    $manager = route('admin.manager.index', ['company_id' => $row->id]);
                    $actionBtn = '<div class="d-flex" style="flex-direction: column;justify-content: initial;align-items: baseline;gap: 10px;"><div><a href=' . $edit . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="edit btn btn-success btn-sm">Edit</a> <button type="submit" data-user-id="' . $row->id . '" class="delete btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteCompany">Delete</button></div> <div class="" style="display: contents;"><a href=' . $hr . ' id="viewHr' . $row->id . '" data-userId="' . $row->id . '" class="hr btn btn-primary btn-sm">View Hr</a> <a href=' . $manager . ' type="submit" data-userId="' . $row->id . '"  class="manager btn btn-primary btn-sm">View Manager</a></div></div>';
                    return $actionBtn;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.company.index');
    }

    public function create(){
        $city = City::get();
        return view('admin.company.create', ['cities' => $city]);
    }

    public function store(Store $request){
        return $this->companyService->store($request);
    }

    public function edit(Company $company){
        $city = City::get();
        return view('admin.company.create', ['company' =>  $company, 'cities' => $city]);
    }

    public function update(Update $request, Company $company){
        return $this->companyService->update($request, $company);
    }

    public function destroy($id){
        return  $this->companyService->destroy($id);
    }
}
