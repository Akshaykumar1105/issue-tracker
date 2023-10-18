<?php
namespace App\Services;

use App\Models\DiscountCoupons;
use Carbon\Carbon;

class DiscountCouponService {

    protected $discountCouponObj;

    public function __construct(){
        $this->discountCouponObj = new DiscountCoupons();
    }

    public function collection(){
        return DiscountCoupons::select('id', 'code', 'is_active','discount', 'discount_type','active_at','expire_at');
    }

    public function store($request){
        $now = Carbon::now()->format('Y-m-d');
        if ($request->active_at <  $now) {
            return ['status' => 'false', 'startAt' =>  'Discount start date must be equal to or later than the current date. Please select a valid start date.'];
        }

        if (!empty($request->active_at) && !empty($request->expire_at)) {
            $startAt = Carbon::createFromFormat('Y-m-d', $request->active_at);
            $endsAt = Carbon::createFromFormat('Y-m-d', $request->expire_at);

            if ($endsAt->gt($startAt) == false) {
                return ['status' => 'false', 'endAt' => 'Expiry date must be greater than the start date'];
            }
        }
        $coupon = $this->discountCouponObj;
        $coupon->fill($request->all())->save();
        if($coupon){
            return  [
                'success' => __('entity.entityCreated', ['entity' => 'Discount Coupon']),
                'route' => "route('admin.discount-coupon.index')"
            ];
        }
    }


    public function edit($id){
       return DiscountCoupons::find($id);
    }

    public function update($request, $id){
        $now = Carbon::now()->format('Y-m-d');
        if ($request->active_at <  $now) {
            return ['status' => 'false', 'startAt' =>  'Discount start date must be equal to or later than the current date. Please select a valid start date.'];
        }

        if (!empty($request->active_at) && !empty($request->expire_at)) {
            $startAt = Carbon::createFromFormat('Y-m-d', $request->active_at);
            $endsAt = Carbon::createFromFormat('Y-m-d', $request->expire_at);

            if ($endsAt->gt($startAt) == false) {
                return ['status' => 'false', 'endAt' => 'Expiry date must be greater than the start date'];
            }
        }
        $coupon = $this->discountCouponObj->find($id);
        $coupon->fill($request->all())->save();
        return  [
            'success' => __('entity.entityUpdated', ['entity' => 'Discount Coupon']),
            'route' => route('admin.discount-coupon.index')
        ];
    }

    public function destory($id){
        $coupon = DiscountCoupons::find($id)->delete();

        if($coupon){
            return [
                'success' => __('entity.entityDeleted', ['entity' => 'Discount Coupon']),
            ];
        }
    }

    public function changeStatus($request){
        $couponId = $request->couponId;
        $isActive = $request->status == config('site.status.active') ? config('site.status.is_active') : config('site.status.active');
        $this->discountCouponObj->where('id', $couponId)->update(['is_active' => $isActive]);
        $message = $isActive ? __('messages.status.active') : __('messages.status.inactive');
        return ['success' => $message];
    }
}
?>