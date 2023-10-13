<?php

namespace App\Services;

use App\Jobs\IssueReportSubmission as JobsIssueReportSubmission;
use App\Mail\IssueReportSubmission;
use App\Models\CommentUpvotes;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\New_;
use Yajra\DataTables\Facades\DataTables;

class CompanyService
{

    protected $companyModel;
    protected $managerService;
    protected $hrService;


    public function __construct(ManagerService $managerService, HrService $hrService){
        $this->companyModel = new Company();
        $this->managerService = $managerService;
        $this->hrService = $hrService;
    }

    public function index(){
        return Company::where('is_active', config('site.status.active'))->get();
    }

    public function collection($companyId, $request){
        $query = Company::select('id', 'name', 'email', 'number', 'address', 'is_active', 'created_at');

        if ($request->listing == config('site.role.hr')) {
            $query =  $this->hrService->collection($companyId, $request);
        } else if ($request->listing == config('site.role.manager')) {
            $query = $this->managerService->collection($companyId, $request);
        }
        return $query;
    }

    public function store($request){
        $this->companyModel->fill($request->all())->save();
        $company = Company::where('email', $request->email)->first();
        $email = $company->email;
        $companyUuid = $company->uuid;
        // dd($email);
        JobsIssueReportSubmission::dispatchSync($email);
        // Mail::to($email)->send(new IssueReportSubmission($companyUuid));
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

    public function destroy(){
        $id = request()->id;
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
