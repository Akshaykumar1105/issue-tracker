<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Jobs\IssueReportSubmission as JobsIssueReportSubmission;

class CompanyService
{
    protected $companyModel;

    public function __construct(){
        $this->companyModel = new Company();
    }

    public function index(){
        return $this->companyModel::where('is_active', config('site.status.active'))->get();
    }

    public function collection(){
        return $this->companyModel::with('city')->select('id', 'name', 'email', 'city_id', 'number', 'address', 'is_active', 'created_at');
    }

    public function store($request){
        $this->companyModel->fill($request->all())->save();
        $company = $this->companyModel::where('email', $request->email)->first();
        $email = $company->email;
        JobsIssueReportSubmission::dispatchSync($email);
        return [
            'success' => __('entity.entityCreated', ['entity' => 'Company']),
            'route' => route('admin.company.index')
        ];
    }

    public function update($request, $company){
        $company->fill($request->validated());
        $company->save();
        return  [
            'success' => __('entity.entityUpdated', ['entity' => 'Company']),
            'route' => route('admin.company.index')
        ];
    }

    public function destroy($id){
        $this->companyModel->where('id', $id)->delete();
        return [
            'success' => __('entity.entityDeleted', ['entity' => 'Company']),
        ];
    }

    public function status($request){
        $company = $request->userId;
        $isActive = $request->status == config('site.status.active') ? config('site.status.is_active') : config('site.status.active');
        $this->companyModel->where('id', $company)->update(['is_active' => $isActive]);
        $message = $isActive ? __('messages.status.active') : __('messages.status.inactive');
        return ['success' => $message];
    }
}
