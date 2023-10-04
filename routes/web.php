<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hr\HrController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Hr\ManagerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CompanyStatusController;
use App\Http\Controllers\User\ChangePasswordController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentUpvoteController;
use App\Http\Controllers\Hr\IssueController as HrIssueController;
use App\Http\Controllers\User\IssueController as UserIssueController;
use App\Http\Controllers\Hr\DashboardController as HrDashboardController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\IssueController as ManagerIssueController;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.signin');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('forgot-password', [ForgetPasswordController::class, 'index'])->name('forgot-password');
Route::post('forgot-password', [ForgetPasswordController::class, 'store'])->name('forgot-Password.store');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('reset-password.index');
Route::patch('reset-password/update', [ResetPasswordController::class, 'update'])->name('reset-password.update');

Route::get('companies/{company}/create-issue', [UserIssueController::class, 'index'])->name('issue.index');
Route::post('companies/post-issue', [UserIssueController::class, 'store'])->name('issue.store');

//hr register route
Route::prefix('/hr')->group(function () {
    Route::get('/register', [HrController::class, 'index'])->name('hr.register.index');
    Route::post('/register', [HrController::class, 'store'])->name('hr.register.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Admin Profile
    Route::resource('/profile', ProfileController::class)->only(['index', 'update']);
    
    // Change Password
    Route::resource('/change-password', ChangePasswordController::class)->only(['index', 'update']);
    
    // Company
    Route::resource('/company', CompanyController::class);
    Route::post('/status', CompanyStatusController::class)->name('company.status');

    // User
    Route::prefix('/user')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::get('/manager/{manager}', [UserController::class, 'show'])->name('user.show');
    });
    
    //issue
    Route::resource('/issue', IssueController::class)->only(['index', 'show', 'destroy']);  
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

    //pending issue

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

Route::post('/issue/comment/{commentId}/upvotes', [CommentUpvoteController::class, 'store'])->name('comment.upvote.post');
Route::delete('/issue/comment/{commentId}/upvotes', [CommentUpvoteController::class, 'destroy'])->name('comment.upvote.destroy');
// Route::resource('/comment-upvotes', CommentUpvoteController::class)->only(['destroy']);
Route::get('/comment', [CommentController::class, 'index'])->name('comment.index');