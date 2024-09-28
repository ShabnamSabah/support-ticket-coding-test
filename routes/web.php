<?php

use App\Http\Controllers\backend\admin\CustomerController;
use App\Http\Controllers\backend\admin\DashboardController;
use App\Http\Controllers\backend\admin\ProfileController;
use App\Http\Controllers\backend\AuthenticationController;
use App\Http\Controllers\backend\customer\TicketController;
use App\Http\Controllers\backend\customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\backend\customer\ProfileController as CustomerProfileController;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\CustomerAuthenticationMiddleware;
use Illuminate\Support\Facades\Route;


// backend 
Route::match(['get', 'post'], '/', [AuthenticationController::class, 'login'])->name('login');
// route prefix 
Route::prefix('admin')->group(function () {
    // route name prefix 
    Route::name('admin.')->group(function () {
        //middleware 
        Route::middleware(AdminAuthenticationMiddleware::class)->group(function () {
            Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
            //profile 
            Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
            Route::post('profile-info/update', [ProfileController::class, 'profile_info_update'])->name('profile.info.update');
            Route::post('profile-password/update', [ProfileController::class, 'profile_password_update'])->name('profile.password.update');
            //dashboard
            Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

            //ticket-response
            Route::match(['get', 'post'], 'ticket/response/{id}', [DashboardController::class, 'ticket_response'])->name('ticket.response');
            Route::get('ticket-response/list/{id}', [DashboardController::class, 'ticket_response_list'])->name('ticket.response.list');

            //customer
            Route::match(['get', 'post'], 'customer/add', [CustomerController::class, 'customer_add'])->name('customer.add');
            Route::match(['get', 'post'], 'customer/edit/{id}', [CustomerController::class, 'customer_edit'])->name('customer.edit');
            Route::get('customer/list', [CustomerController::class, 'customer_list'])->name('customer.list');
            Route::get('customer/delete/{id}', [CustomerController::class, 'customer_delete'])->name('customer.delete');

            
        });
    });
});
// Advocate 
// route prefix
Route::prefix('customer')->group(function () {
    // route name prefix
    Route::name('customer.')->group(function () {
        //middleware 
            Route::middleware(CustomerAuthenticationMiddleware::class)->group(function () {
            Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
            //profile 
            Route::get('profile', [CustomerProfileController::class, 'profile'])->name('profile');
            Route::post('profile-info/update', [CustomerProfileController::class, 'profile_info_update'])->name('profile.info.update');
            Route::post('profile-password/update', [CustomerProfileController::class, 'profile_password_update'])->name('profile.password.update');
            //dashboard 
            Route::get('dashboard', [CustomerDashboardController::class, 'dashboard'])->name('dashboard');
            
            //ticket
            Route::match(['get', 'post'], 'ticket/add', [TicketController::class, 'ticket_add'])->name('ticket.add');
            
            Route::get('ticket/list', [TicketController::class, 'ticket_list'])->name('ticket.list');
            Route::get('ticket-response/list/{id}', [TicketController::class, 'ticket_response_list'])->name('ticket.response.list');
            Route::match(['get', 'post'],'ticket-close/{id}', [TicketController::class, 'ticket_close'])->name('ticket.close');
        });
    });
});
