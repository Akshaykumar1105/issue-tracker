<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;
use App\Models\CommentUpvotes;
use App\Mail\IssueReportSubmission;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use App\Jobs\IssueReportSubmission as JobsIssueReportSubmission;

class CompanyService
{

    protected $companyModel;
    protected $managerService;
    protected $hrService;


    public function __construct(){
        $this->companyModel = new Company();
        $this->managerService = new ManagerService();
        $this->hrService = new HrService;
    }

    public function index(){
        return $this->companyModel::where('is_active', config('site.status.active'))->get();
    }

    public function collection($companyId, $request){
        $query = $this->companyModel::with('city')->select('id', 'name', 'email', 'city_id', 'number', 'address', 'is_active', 'created_at');

        if ($request->listing == config('site.role.hr')) {
            $query =  $this->hrService->collection($companyId, $request);
        } else if ($request->listing == config('site.role.manager')) {
            $query = $this->managerService->collection($companyId, $request);
        }
        return $query;
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
