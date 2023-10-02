<?php

namespace App\Services;

use App\Mail\IssueReportSubmission;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\New_;
use Yajra\DataTables\Facades\DataTables;

class CompanyService
{

    protected $companyModel;
    protected $managerService;
    protected $hrService;


    public function __construct(ManagerService $managerService, HrService $hrService)
    {
        $this->companyModel = new Company();
        $this->managerService = $managerService;
        $this->hrService = $hrService;
    }

    public function collection($companyId, $request)
    {

        if ($request->listing == config('site.role.hr')) {
            return $this->hrService->collection($companyId, $request);
        } else if ($request->listing == config('site.role.manager')) {
            return $this->managerService->collection($companyId, $request);
        }
    }

    public function store($request)
    {
        $this->companyModel->fill($request->all())->save();

        $company = Company::where('email', $request->email)->first();
        $email = $company->email;
        $companyUuid = $company->uuid;
        Mail::to($email)->send(new IssueReportSubmission($companyUuid));
        return [
            'success' => __('entity.entityCreated', ['entity' => 'Company']),
            'route' => route('admin.company.index')
        ];
    }

    public function update($request, $company)
    {
        // $company = Company::where('id', $company)->first();
        $company->fill($request->validated());
        $company->save();

        return  [
            'success' => __('entity.entityUpdated', ['entity' => 'Company']),
            'route' => route('admin.company.index')
        ];
    }

    public function destroy()
    {
        $id = request()->id;
        Company::where('id', $id)->delete();
        return [
            'success' => __('entity.entityDeleted', ['entity' => 'Company']),
        ];
    }

    public function status($request){
        $company = $request->userId;
        $isActive = $request->status == 1 ? config('site.status.is_active') : config('site.status.active');

        Company::where('id', $company)->update(['is_active' => $isActive]);

        $message = $isActive ? __('messages.status.active') : __('messages.status.inactive');
        return ['success' => $message];
    }
}
