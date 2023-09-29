<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;

class CompanyStatusController extends Controller{
    protected $companyService;

    public function __construct(CompanyService $companyService){
        $this->companyService = $companyService;
    }
    public function __invoke(Request $request){ 
        return $this->companyService->status($request);   
    }
}
