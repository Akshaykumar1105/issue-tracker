<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\CouponService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\Coupon\Store;
use App\Http\Requests\Admin\Coupon\Update;

class CouponController extends Controller
{

    protected $discountCouponService;

    public function __construct(CouponService $discountCouponService){
        $this->discountCouponService = $discountCouponService;
    }

    public function index(Request $request){
        if($request->ajax()){
            $query = $this->discountCouponService->collection();
            return DataTables::of($query)
                ->orderColumn('code', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('activeAt', function ($row) {
                    if ($row->active_at) {
                        return date( config('site.date'), strtotime($row->active_at));
                    } else {
                        return 'Not select due date';
                    }
                })
                ->addColumn('expireAt', function ($row) {
                    if ($row->expire_at) {
                        return date( config('site.date'), strtotime($row->expire_at));
                    } else {
                        return 'Not select due date';
                    }
                })
                ->addColumn('action', function ($row) {
                    $edit = route('admin.discount-coupon.edit', ['discount_coupon' => $row->id]);
                    $actionBtn = '<div class="d-flex" style="flex-direction: column;justify-content: initial;align-items: baseline;gap: 10px;"><div><a href=' . $edit . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt" style="margin: 0 5px 0 0"></i>Edit</a> <button type="submit" data-user-id="' . $row->id . '" class="delete btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteCouponModel"><i class="fas fa-trash" style="margin: 0 5px 0 0;"></i>Delete</button></div></div>';
                    return $actionBtn;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.coupon.index');
    }

    public function create(){
        return view('admin.coupon.create');
    }

    public function store(Store $request){
        return $this->discountCouponService->store($request);
    }

    public function edit(string $id){
        $coupon = $this->discountCouponService->edit($id);
        return view('admin.coupon.create', ['coupon' => $coupon]);
    }

    public function update(Update $request, string $id){
        return $this->discountCouponService->update($request, $id);
    }

    public function destroy(string $id){
        return $this->discountCouponService->destory($id);
    }
}
