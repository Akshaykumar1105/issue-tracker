<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function create(){
        $cities = City::get();
        $subscriptionPlans = Subscription::all();
        return view('front.company.create', ['cities' => $cities, 'subscriptionPlans' => $subscriptionPlans]);
    }

    public function validateStep(Request $request){
        $validator = Validator::make($request->all(), [
            'companyname' => 'required|min:6|max:255',
            'email' => 'required|email|unique:companies,email',
            'number' => 'required|min:10|digits:10',
            'address' => 'required',
            'city_id' => 'required|exists:cities,id',
        ]);

        $subscription = Subscription::where('name', $request->subscription_name)->first();
        $subscriptionName = $subscription->name;
        if($subscription->discount_price){
            $subscriptionPrice = $subscription->price - $subscription->discount_price;
        }else{
            $subscriptionPrice = $subscription->price;
        }
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->first(), // You can customize the error message here
            ]);
        }
    
        return response()->json(['success' => true,  'subscription_name' => $subscriptionName, 'amount' => $subscriptionPrice]);
    }

    public function validateStepSecond(Request $request){
        
    }

    public function applyDiscount(Request $request){
        $coupon = Coupon::where('code', $request->discount_code)->first();

        $now = Carbon::now();
        $nowFormatted = $now->format('Y-m-d');

        if (!$coupon) {
            return  ['status' => 'false', 'message' => 'Invalid coupon code'];
        }


        if (!$coupon->is_active) {
            return ['status' => 'false', 'message' => 'Coupon is currently inactive'];
        }

        if ($coupon->active_at && $nowFormatted < $coupon->active_at) {;
            return ['status' => 'false', 'message' => 'Coupon is not yet active'];
        }

        if ($coupon->expire_at && $nowFormatted > $coupon->expire_at) {
            return ['status' => 'false', 'message' => "Coupon code has expired"];
        }

        return ['status' => 'true', 'message' => 'Discount applied successfully', 'coupon' => $coupon];
    }
}
