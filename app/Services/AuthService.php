<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Jobs\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\ConfirmPassword;
use App\Mail\ResetPasswordEmail;
use App\Models\PasswordResetToken;
use App\Mail\ConfirmPasswordEmail;
use Illuminate\Support\Facades\Log;
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

        if ($user->hasRole(config('site.role.admin'))) {
            return  [
                'success' =>  __('messages.auth.login'),
                'route' => route('admin.dashboard')
            ];
        }
        else if ($user->hasRole(config('site.role.hr')) && $company->is_active == config('site.status.active') ) {
            
            return [
                'success' =>  __('messages.auth.login'),
                'route' => route('hr.dashboard')
            ];
        }
        else if ($user->hasRole(config('site.role.manager')) && $company->is_active == config('site.status.active') ) {
            return[
                'success' =>  __('messages.auth.login'),
                'route' => route('manager.dashboard')
            ];
        }
        else {
            $this->logout();
            return [
                'success' =>  __('messages.auth.not-valid'),
                'route' => route('home')
            ];
        }
    }

    public function logout(){
        auth()->logout();
        return [
            'success' =>  __('messages.auth.logout'),
            'route' => route('login')
        ];
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
            try {
                ResetPassword::dispatch([
                    'email' => $request->email,
                    'token' => $token,
                ]);
            } catch (Exception $e) {
                Log::info($e);
            }
            
            return['message' => __('messages.email.reset-email')];
        } else {
            return ['message' => __('messages.email.email-fail')];
        }
    }

    public function updateResetPassword($request){
        $token = PasswordResetToken::where('token' , $request->token)->first();
        $email =$token->email;
        if (!$token) {
            return abort(404);
        }

        User::where('email', $email)->update(['password' => Hash::make($request->password)]);

        try {
            ConfirmPassword::dispatch($email);
        } catch (Exception $e) {
            Log::info($e);
        }
        

        PasswordResetToken::where(['token' => $request->token])->delete();

        return response()->json(['success' => 'Password has been reseted.', 'route' => route('login')]);
    }

    public function changePassword($request){
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return response()->json([
                'error' =>  __('messages.password.not_match')
            ],401);
        }
        User::where('id', auth()->user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return [
            'success' =>  __('entity.entityUpdated', ['entity' => 'Your password'])
        ];
    }


    public function resetPassword($token){
        $resetToken = PasswordResetToken::where('token', $token)->first();
        if($resetToken){
            if(Carbon::now()->greaterThan($resetToken->created_at->addMinutes(config('site.password.expired')))){
                $resetToken->delete();
                return abort(404);
            }
            return view('auth.reset-password' , ['token' => $token] );
        }
        return redirect()->route('home');
    }
}
