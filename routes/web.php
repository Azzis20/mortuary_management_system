<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoomController;  //??

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\DeceasedController;
use App\Http\Controllers\Client\BookServiceController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\BillingController;
// use App\Http\Controllers\Client\ViewingController; //
use App\Http\Controllers\Client\ClientDeceasedStatusController; 
use App\Http\Controllers\Client\ViewingController;


use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\RetrievalScheduleController;
use App\Http\Controllers\Admin\AdminDeceasedController;     
use App\Http\Controllers\Admin\BookingController; 
use App\Http\Controllers\Admin\DashboardController;  
use App\Http\Controllers\Admin\EmployeeManagementController; 
use App\Http\Controllers\Admin\InventoryController; 
use App\Http\Controllers\Admin\ClientController; 
use App\Http\Controllers\Admin\AdminTrackingController; 
use App\Http\Controllers\Admin\PackageItemController;
use App\Http\Controllers\Admin\AdminBillController; 
use App\Http\Controllers\Admin\AdminViewController;
use App\Http\Controllers\Admin\AdminEmbalmingController;
use App\Http\Controllers\Admin\StaffAssignmentController;


use App\Http\Controllers\Staff\StaffDashboardController;


use App\Http\Controllers\Driver\DriverDashboardController;
                              

use App\Http\Controllers\Embalmer\EmbalmerDashboardController;




// Landing page - redirect to appropriate dashboard if logged in
Route::get('/', [AuthController::class,'landingPage'])->name('home');

// Guest routes (only accessible when NOT logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});



Route::middleware(['auth', 'role:driver'])
    ->prefix('driver')
    ->name('driver.')
    ->group(function () {


        Route::get('/dashboard', [DriverDashboardController::class, 'index'])
            ->name('dashboard');
        
        
        Route::get('/deliveries', [DriverController::class, 'deliveries'])
            ->name('deliveries');
});

Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])
            ->name('dashboard');
        
       
        Route::get('/tasks', [StaffController::class, 'tasks'])
            ->name('tasks');
});

Route::middleware(['auth', 'role:embalmer'])
    ->prefix('embalmer')
    ->name('embalmer.')
    ->group(function () {


        Route::get('/dashboard', [EmbalmerDashboardController::class, 'index'])
            ->name('dashboard');
        
        
});







// ADMIN Routes (accessible to admin and superadmin only)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');




    // Task-Assignment
Route::prefix('assignments')->name('assignments.')->group(function () {
    // Main index page
    Route::get('/tasks', [StaffAssignmentController::class, 'index'])
        ->name('index');
    
    // Create new task for a booking
    Route::post('/bookings/{booking}/tasks', [StaffAssignmentController::class, 'createTask'])
        ->name('createTask');
    
    // Assign staff to task and update status
    Route::put('/tasks/{task}/assign', [StaffAssignmentController::class, 'assignTask'])
        ->name('assignTask');
    
    // Delete a task
    Route::delete('/tasks/{task}', [StaffAssignmentController::class, 'deleteTask'])
        ->name('deleteTask');
    
    // Quick status update (optional - for AJAX)
    Route::patch('/tasks/{task}/status', [StaffAssignmentController::class, 'updateTaskStatus'])
        ->name('updateTaskStatus');
    
    // Staff workload view (optional analytics)
    Route::get('/workload', [StaffAssignmentController::class, 'staffWorkload'])
        ->name('workload');
});

    
    Route::get('/retrieval', [RetrievalScheduleController::class, 'index'])->name('retrieval');


    // Bill Management
    

    // Booking Management
    Route::get('/booking', [BookingController::class,'index'])->name('booking.index');
    Route::get('/booking/active-case', [BookingController::class,'selectActiveCase'])->name('booking.activeCase');
    Route::get('/booking/confirmed', [BookingController::class,'selectConfirmed'])->name('booking.confirmed');
    Route::get('/booking/pending', [BookingController::class,'selectPending'])->name('booking.pending');
    Route::get('/booking/completed', [BookingController::class,'selectCompleted'])->name('booking.completed');
    Route::get('/booking/declined', [BookingController::class,'selectDeclined'])->name('booking.declined');
    Route::get('/booking/search', [BookingController::class,'search'])->name('booking.search');
    Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::put('/bookings/{id}/decline', [BookingController::class, 'declineBooking'])->name('booking.decline');

  


    
    // Client Management
    Route::get('/client',[ClientController::class,'index'])->name('client');
    Route::get('/client/{id}/show',[ClientController::class,'show'])->name('client.show');
    Route::get('/client/{id}/booking',[ClientController::class,'booking'])->name('client.booking');
    Route::get('/client/search',[ClientController::class,'search'])->name('client.search');

    // Deceased Management
    Route::get('/deceased',[AdminDeceasedController::class,'index'])->name('deceased');
    Route::get('/deceased/search', [AdminDeceasedController::class,'search'])->name('deceased.search');
    Route::get('/deceased/{id}/show', [AdminDeceasedController::class,'show'])->name('deceased.show');


    // Employee Management
    Route::get('/employee', [EmployeeManagementController::class,'index'])->name('employee');
    Route::get('/employee/{id}/edit', [EmployeeManagementController::class,'edit'])->name('employee.edit');
    Route::get('/employee/create', [EmployeeManagementController::class,'create'])->name('employee.create');
    Route::get('/employee/{id}/show', [EmployeeManagementController::class,'show'])->name('employee.show');
    Route::post('/employee', [EmployeeManagementController::class, 'store'])->name('employee.store');
    Route::get('/employee/search', [EmployeeManagementController::class, 'search'])->name('employee.search');

    // Inventory Management
    Route::get('/inventory', [InventoryController::class,'index'])->name('inventory');
    Route::get('/inventory/{id}/edit', [InventoryController::class,'edit'])->name('inventory.edit');
    Route::get('/inventory/search', [InventoryController::class,'search'])->name('inventory.search');
    Route::get('/inventory/stock-shortage', [InventoryController::class,'stockShortage'])->name('inventory.shortage');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');

    // Packages Management - CREATE routes first
    Route::get('/services/create', [ServicesController::class, 'create'])->name('services.create');
    Route::post('/services', [ServicesController::class, 'store'])->name('services.store');

    // Package Item Management - Specific routes BEFORE {package} routes
    Route::get('/services/package-item/create/{package}', [PackageItemController::class, 'create'])->name('package.create');
    Route::post('/services/package-items', [PackageItemController::class, 'store'])->name('package.store');
    Route::get('/services/package-item/{item}/edit', [PackageItemController::class, 'edit'])->name('package.edit');
    Route::put('/services/package-item/{item}', [PackageItemController::class, 'update'])->name('package.update');
    Route::delete('/services/package-item/{item}', [PackageItemController::class, 'destroy'])->name('package.destroy');

    // Packages Management - General routes with {package} parameter LAST
    Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
    Route::get('/services/{package}/edit', [ServicesController::class, 'edit'])->name('services.edit');
    Route::put('/services/{package}', [ServicesController::class, 'update'])->name('services.update');
    Route::delete('/services/{package}', [ServicesController::class, 'destroy'])->name('services.destroy');
    Route::get('/services/{package}/inclusion', [ServicesController::class, 'inclusion'])->name('services.inclusion');


    //Viewing Management

    Route::get('/viewing', [AdminViewController::class, 'index'])->name('viewing.index');

    //Embalming Managment //AdminEmbalmingController
    
    Route::get('/embalming', [AdminEmbalmingController::class, 'index'])->name('embalming.index');

    // Room Management
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
  

            // View routes only
    Route::get('/bill', [AdminBillController::class, 'index'])->name('bill');
    Route::get('/bill/{id}', [AdminBillController::class, 'show'])->name('bill.show');
        
        // Update route (for manual adjustments if needed)
    Route::put('/bill/{id}', [AdminBillController::class, 'update'])->name('bill.update');
        
        // Payment related routes
    Route::get('/bill/{id}/payment', [AdminBillController::class, 'showPaymentForm'])->name('bill.payment-form');
    Route::post('/bill/{id}/payment', [AdminBillController::class, 'processPayment'])->name('bill.process-payment');
    Route::get('/bill/payments/history', [AdminBillController::class, 'paymentHistory'])->name('bill.payment-history');

});


// CLIENT Routes - Profile routes WITHOUT profile check middleware
Route::middleware(['auth', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/profiles', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profiles/create', [ProfileController::class, 'create'])->name('profile.create');
        Route::post('/profiles', [ProfileController::class, 'store'])->name('profile.store');
        Route::get('/profiles/{profile}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profiles/{profile}', [ProfileController::class, 'update'])->name('profile.update');
    });

// CLIENT Routes - All other routes WITH profile check middleware
Route::middleware(['auth', 'role:client', 'client.profile'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        // Client Dashboard
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

        // Register Deceased
        Route::get('/deceases', [DeceasedController::class, 'index'])->name('decease.index');
        Route::get('/deceases/create', [DeceasedController::class, 'create'])->name('decease.create');
        Route::post('/deceases', [DeceasedController::class, 'store'])->name('decease.store');
        Route::get('/deceases/{deceased}', [DeceasedController::class, 'show'])->name('decease.show');
        Route::get('/deceases/{deceased}/edit', [DeceasedController::class, 'edit'])->name('decease.edit');
        Route::put('/deceases/{deceased}', [DeceasedController::class, 'update'])->name('decease.update');
        Route::delete('/deceases/{deceased}', [DeceasedController::class, 'destroy'])->name('decease.destroy');

        // Client Services
        Route::get('/services', [BookServiceController::class,'index'])->name('services.index');
        Route::get('/services/create/{package}', [BookServiceController::class, 'create'])->name('services.create');
        Route::post('/services/store', [BookServiceController::class, 'store'])->name('services.store');
        Route::get('/my-bookings', [BookServiceController::class, 'myBookings'])->name('services.booking');


        // Client Deceased Status


        Route::prefix('viewing')->name('viewing.')->group(function () {
            Route::get('/', [ViewingController::class, 'index'])->name('index');
            Route::get('/create/{booking}', [ViewingController::class, 'create'])->name('create');
            Route::post('/store/{booking}', [ViewingController::class, 'store'])->name('store');
            Route::get('/{viewing}', [ViewingController::class, 'show'])->name('show');
            Route::get('/{viewing}/edit', [ViewingController::class, 'edit'])->name('edit');
            Route::put('/{viewing}', [ViewingController::class, 'update'])->name('update');
            Route::patch('/{viewing}/cancel', [ViewingController::class, 'cancel'])->name('cancel');
            Route::delete('/{viewing}', [ViewingController::class, 'destroy'])->name('destroy');
        });




        
        //Client Billing
        Route::get('/billing',[BillingController::class, 'index'])->name('billing.index');
        Route::post('/payment/process', function () {
            return redirect()->route('client.billing')->with('success', 'Payment processed successfully.');
        })->name('payment.process');
    });

// Shared authenticated routes (accessible to all logged-in users)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});