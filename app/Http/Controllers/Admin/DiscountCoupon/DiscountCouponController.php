<?php

namespace App\Http\Controllers\Admin\DiscountCoupon;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DiscountCoupons;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\DiscountCoupon\Store;
use App\Http\Requests\Admin\DiscountCoupon\Update;
use App\Services\DiscountCouponService;

class DiscountCouponController extends Controller
{

    protected $discountCouponService;

    public function __construct(DiscountCouponService $discountCouponService){
        $this->discountCouponService = $discountCouponService;
    }

    public function index(Request $request){
        if($request->ajax()){
            $query = $this->discountCouponService->collection();
            return DataTables::of($query)
                ->orderColumn('code', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('action', function ($row) {
                    $edit = route('admin.discount-coupon.edit', ['discount_coupon' => $row->id]);
                    $actionBtn = '<div class="d-flex" style="flex-direction: column;justify-content: initial;align-items: baseline;gap: 10px;"><div><a href=' . $edit . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="edit btn btn-success btn-sm">Edit</a> <button type="submit" data-user-id="' . $row->id . '" class="delete btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteCouponModel">Delete</button></div></div>';
                    return $actionBtn;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.discount-coupon.index');
    }

    public function create(){
        return view('admin.discount-coupon.create');
    }

    public function store(Store $request){
        return $this->discountCouponService->store($request);
    }

    public function edit(string $id){
        $coupon = $this->discountCouponService->edit($id);
        return view('admin.discount-coupon.create', ['coupon' => $coupon]);
    }

    public function update(Update $request, string $id){
        return $this->discountCouponService->update($request, $id);
    }

    public function destroy(string $id){
        return $this->discountCouponService->destory($id);
    }
}
