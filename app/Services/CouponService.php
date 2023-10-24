<?php
namespace App\Services;

use App\Models\Coupon;

class CouponService {

    protected $discountCouponObj;

    public function __construct(){
        $this->discountCouponObj = new Coupon();
    }

    public function collection(){
        return Coupon::select('id', 'code', 'is_active','discount', 'discount_type','active_at','expire_at');
    }

    public function store($request){
        $coupon = $this->discountCouponObj;
        $coupon->fill($request->all())->save();
        if($coupon){
            return  [
                'success' => __('entity.entityCreated', ['entity' => 'Discount Coupon']),
                'route' => route('admin.discount-coupon.index')
            ];
        }
    }


    public function edit($id){
       return Coupon::find($id);
    }

    public function update($request, $id){
        $coupon = $this->discountCouponObj->find($id);
        $coupon->fill($request->all())->save();
        return  [
            'success' => __('entity.entityUpdated', ['entity' => 'Discount Coupon']),
            'route' => route('admin.discount-coupon.index')
        ];
    }

    public function destory($id){
        $coupon = Coupon::find($id)->delete();
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