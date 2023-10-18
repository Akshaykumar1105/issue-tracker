<?php

namespace App\Http\Controllers\Admin\DiscountCoupon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DiscountCouponService;

class DiscountCouponStatus extends Controller
{

    protected $discountCouponService;

    public function __construct(DiscountCouponService $discountCouponService){
        $this->discountCouponService = $discountCouponService;
    }

    public function __invoke(Request $request){
        return $this->discountCouponService->changeStatus($request);
    }
}
