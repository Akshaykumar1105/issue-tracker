<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordEmail;
use App\Models\PasswordResetToken;
use App\Mail\ConfirmPasswordEmail;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthService
{
    public function login($request){
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }

      
        $user = auth()->user();
        $company = Company::find($user->company_id);
        // dd($company->is_active == config('site.status.active')); 

        if ($user->hasRole(config('site.role.admin'))) {
            return  response()->json([
                'success' =>  __('messages.auth.login'),
                'route' => route('admin.dashboard')
            ]);
        }
        else if ($user->hasRole(config('site.role.hr')) && $company->is_active == config('site.status.active') ) {
            
            return  response()->json([
                'success' =>  __('messages.auth.login'),
                'route' => route('hr.dashboard')
            ]);
        }
        else if ($user->hasRole(config('site.role.manager')) && $company->is_active == config('site.status.active') ) {
            return  response()->json([
                'success' =>  __('messages.auth.login'),
                'route' => route('manager.dashboard')
            ]);
        }
        else {
            $this->logout();
            return response()->json([
                'success' =>  __('messages.auth.not-valid'),
                'route' => route('home')
            ]);
        }
    }

    public function logout(){
        auth()->logout();
        return response()->json([
            'success' =>  __('messages.auth.logout'),
            'route' => route('login')
        ]);
    }


    public function forgetPassword($request){
        $token = Str::random(64);
        $validation = $request->only('email');
        
        if ($validation) {
            PasswordResetToken::insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            Mail::to($request->email)->send(new ResetPasswordEmail($token));
            return response()->json(['message' => __('messages.email.reset-email')]);
        } else {
            return response()->json(['message' => __('messages.email.email-fail')]);
        }
    }

    public function resetPassword($request){
        $token = PasswordResetToken::where([
            'token' => $request->token
        ])->first();

        $email =$token->email;

        if (!$token) {
            return abort(404);
        }

        User::where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);

        Mail::to($email)->send(new ConfirmPasswordEmail());

        PasswordResetToken::where([
            'token' => $request->token,
        ])->delete();

        return response()->json(['success' => 'Password has been reseted!', 'route' => route('login')]);
    }

    public function changePassword($request){
        // dd($request);
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return response()->json([
                'error' =>  __('messages.password.not_macth')
            ],401);
        }
        #Update the new Password
        User::where('id', auth()->user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' =>  __('entity.entityUpdated', ['entity' => 'Your password'])
        ]);
    }


    public function resetPasswordIndex($token){
        $resetToken = PasswordResetToken::where('token', $token)->first();
        if($resetToken){

            if(Carbon::now()->greaterThan($resetToken->created_at->addMinutes(config('site.password.expired')))){
                $resetToken->delete();
                return abort(404);
            }

            return view('auth.reset_password' , ['token' => $token] );
        }

        return redirect()->route('home');
    }
}
