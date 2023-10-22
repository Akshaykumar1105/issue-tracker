<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponStatusController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService){
        $this->couponService = $couponService;
    }

    public function __invoke(Request $request){
        return $this->couponService->changeStatus($request);
    }
}
