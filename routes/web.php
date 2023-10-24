<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hr\HrController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Hr\ManagerController;
use App\Http\Controllers\Admin\HrController as AdminHrController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\CommentUpvoteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CouponStatusController;
use App\Http\Controllers\Admin\CompanyStatusController;
use App\Http\Controllers\User\ChangePasswordController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Hr\IssueController as HrIssueController;
use App\Http\Controllers\User\IssueController as UserIssueController;
use App\Http\Controllers\Hr\DashboardController as HrDashboardController;
use App\Http\Controllers\Admin\ManagerController as AdminManagerController;
use App\Http\Controllers\Manager\IssueController as ManagerIssueController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.signin');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('forgot-password', [ForgetPasswordController::class, 'index'])->name('forgot-password');
Route::post('forgot-password', [ForgetPasswordController::class, 'store'])->name('forgot-Password.store');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('reset-password.index');
Route::patch('reset-password/update', [ResetPasswordController::class, 'update'])->name('reset-password.update');

Route::get('companies/{company}/issue', [UserIssueController::class, 'index'])->name('issue.index');
Route::post('companies/create-issue', [UserIssueController::class, 'store'])->name('issue.store');

//hr register route
Route::prefix('/hr')->group(function () {
    Route::get('/register', [HrController::class, 'create'])->name('hr.register.create');
    Route::post('/register', [HrController::class, 'store'])->name('hr.register.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/issue/chart', [DashboardController::class, 'issueChart'])->name('dashboard.issue.chart');

    // Admin Profile
    Route::resource('/profile', ProfileController::class)->only(['index', 'update']);
    
    // Change Password
    Route::resource('/change-password', ChangePasswordController::class)->only(['index', 'update']);
    
    // Company
    Route::resource('/company', CompanyController::class);
    Route::post('/status', CompanyStatusController::class)->name('company.status');

    //user
    Route::resource('/hr', AdminHrController::class);
    Route::resource('/manager', AdminManagerController::class);

    //issue
    Route::resource('/issue', IssueController::class)->only(['index', 'show', 'destroy']);
    
    Route::resource('/discount-coupon', CouponController::class)->except(['show']);
    Route::post('/discount-coupon/status', CouponStatusController::class)->name('discount-coupon.status');

});

Route::prefix('hr')->name('hr.')->middleware(['auth', 'role:hr'])->group(function () {
    // Dashboard
    Route::get('/dashboard', HrDashboardController::class)->name('dashboard');

    // Profile
    Route::resource('/profile', ProfileController::class)->only(['index', 'update']);
    
    //change
    Route::resource('/change-password', ChangePasswordController::class)->only(['index', 'update']);

    // Manager
    Route::resource('manager', ManagerController::class)->except(['show']);

    // Issue
    Route::resource('issue', HrIssueController::class)->except(['show', 'destroy']);
});


Route::prefix('manager')->name('manager.')->middleware(['auth', 'role:manager'])->group(function () {
    // Dashboard
    Route::get('/dashboard', ManagerDashboardController::class)->name('dashboard');

    // Profile
    Route::resource('/profile', ProfileController::class)->only(['index', 'update']);
    
    //change
    Route::resource('/change-password', ChangePasswordController::class)->only(['index', 'update']);

    //issue
    Route::resource('/issue', ManagerIssueController::class);
});


Route::group(['prefix' => 'issue'], function () {
    Route::post('comment/{commentId}/upvotes', [CommentUpvoteController::class, 'store'])->name('issue.comment.upvote.post');
    
    Route::delete('comment/{commentId}/upvotes', [CommentUpvoteController::class, 'destroy'])->name('issue.comment.upvote.destroy');
    
    Route::get('comment', [CommentController::class, 'index'])->name('issue.comment.index');
    
    Route::patch('comment/{commentId}/edit', [CommentController::class, 'update'])->name('issue.comment.update');
    
    Route::delete('comment/{commentId}/delete', [CommentController::class, 'destroy'])->name('issue.comment.destroy');
});
// Route::post('/issue/comment/{commentId}/upvotes', [CommentUpvoteController::class, 'store'])->name('comment.upvote.post');
// Route::delete('/issue/comment/{commentId}/upvotes', [CommentUpvoteController::class, 'destroy'])->name('comment.upvote.destroy');
// // Route::resource('/comment-upvotes', CommentUpvoteController::class)->only(['destroy']);
// Route::get('/comment', [CommentController::class, 'index'])->name('comment.index');
// Route::patch('/comment/{commentId}/edit', [CommentController::class, 'update'])->name('comment.update');
// Route::delete('/comment/{commentId}/delete', [CommentController::class, 'destroy'])->name('comment.destroy');