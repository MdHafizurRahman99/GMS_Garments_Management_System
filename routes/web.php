<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusniessProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientRequestController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Permission\RolesPermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\StaffScheduleController;
use App\Http\Controllers\TryTestController;
use App\Models\StaffSchedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');

    return 'Cache Cleared!';
});

Route::get('/', function () {
    return view('front-end.home.home');
})->name('/');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('client-request/create', [ClientRequestController::class, 'create'])->name('client_request.create')->middleware('permission:client_request.add');
    Route::post('client-request/store', [ClientRequestController::class, 'store'])->name('client_request.store')->middleware('permission:client_request.add');
    Route::get('client-request/edit/{id}', [ClientRequestController::class, 'edit'])->name('client_request.edit')->middleware('permission:client_request.edit');
    Route::post('client-request/update/{id}', [ClientRequestController::class, 'update'])->name('client_request.update')->middleware('permission:client_request.edit');
    Route::get('client-request/index', [ClientRequestController::class, 'index'])->name('client_request.index')->middleware('permission:client_request.view');
    Route::post('client-request/destroy/{id}', [ClientRequestController::class, 'destroy'])->name('client_request.destroy')->middleware('permission:client_request.delete');

    // Route::resource('client', ClientController::class);
    Route::get('client/create', [ClientController::class, 'create'])->name('client.create')->middleware('permission:client.add');
    Route::get('client/request', [ClientController::class, 'createRequest'])->name('client.request')->middleware('permission:client.view');
    Route::post('client/store', [ClientController::class, 'store'])->name('client.store')->middleware('permission:client.add');
    Route::get('client/edit/{client}', [ClientController::class, 'edit'])->name('client.edit')->middleware('permission:client.edit');
    Route::put('client/update/{client}', [ClientController::class, 'update'])->name('client.update')->middleware('permission:client.edit');
    Route::get('client/index', [ClientController::class, 'index'])->name('client.index')->middleware('permission:client.view');
    Route::get('my-requests', [ClientController::class, 'userIndex'])->name('user.index')->middleware('permission:client.add');
    Route::delete('client/destroy/{client}', [ClientController::class, 'destroy'])->name('client.destroy')->middleware('permission:client.delete');
    Route::get('business/create', [BusinessController::class, 'create'])->name('business.create')->middleware('permission:business.add');
    Route::post('business/store', [BusinessController::class, 'store'])->name('business.store')->middleware('permission:business.add');
    Route::get('business/edit/{business}', [BusinessController::class, 'edit'])->name('business.edit')->middleware('permission:business.edit');
    Route::put('business/update/{business}', [BusinessController::class, 'update'])->name('business.update')->middleware('permission:business.edit');
    Route::get('business/index', [BusinessController::class, 'index'])->name('business.index')->middleware('permission:business.view');
    Route::delete('business/destroy/{business}', [BusinessController::class, 'destroy'])->name('business.destroy')->middleware('permission:business.delete');

    // Route::resource('business', BusinessController::class);

    Route::get('/client-status/{client_id}', [ClientController::class, 'status'])->name('client.status')->middleware('permission:client.approve');
    Route::get('/business-status/{business_id}', [BusinessController::class, 'status'])->name('business.status')->middleware('permission:business.approve');

    Route::get('permission/create', [PermissionController::class, 'create'])->name('permission.create')->middleware('permission:permission.add');
    Route::get('permission/index', [PermissionController::class, 'index'])->name('permission.index');
    Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store')->middleware('permission:permission.add');
    Route::get('permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit')->middleware('permission:permission.edit');
    Route::post('permission/destroy/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy')->middleware('permission:permission.delete');
    Route::post('permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update')->middleware('permission:permission.edit');

    Route::get('role/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:permission.add');
    Route::get('role/index', [RoleController::class, 'index'])->name('role.index');
    Route::post('role/store', [RoleController::class, 'store'])->name('role.store')->middleware('permission:role.add');
    Route::get('role/edit/{role}', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:role.edit');
    Route::post('role/destroy/{role}', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('permission:role.delete');
    Route::post('role/update/{role}', [RoleController::class, 'update'])->name('role.update')->middleware('permission:role.edit');

    Route::get('roles-permission/create', [RolesPermissionController::class, 'create'])->name('roles-permission.create')->middleware('permission:roles_permission.add');
    Route::get('roles-permission/index', [RolesPermissionController::class, 'index'])->name('roles-permission.index')->middleware('permission:roles_permission.view');
    Route::post('roles-permission/store', [RolesPermissionController::class, 'store'])->name('roles-permission.store')->middleware('permission:roles_permission.add');
    Route::get('roles-permission/edit/{roles_permission}', [RolesPermissionController::class, 'edit'])->name('roles-permission.edit')->middleware('permission:roles_permission.edit');
    Route::post('roles-permission/destroy/{roles_permission}', [RolesPermissionController::class, 'destroy'])->name('roles-permission.destroy')->middleware('permission:roles_permission.add');
    Route::post('roles-permission/update/{roles_permission}', [RolesPermissionController::class, 'update'])->name('roles-permission.update')->middleware('permission:roles_permission.edit');

    Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create')->middleware('permission:admin.add');
    Route::post('admin/store', [AdminController::class, 'store'])->name('admin.store')->middleware('permission:admin.add');
    Route::get('admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit')->middleware('permission:admin.edit');
    Route::post('admin/update/{id}', [AdminController::class, 'update'])->name('admin.update')->middleware('permission:admin.edit');
    Route::get('admin/index', [AdminController::class, 'index'])->name('admin.index')->middleware('permission:admin.view');
    Route::post('admin/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy')->middleware('permission:admin.delete');

    // Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create')->middleware('permission:staff.add');
    // Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store')->middleware('permission:staff.add');
    Route::get('staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit')->middleware('permission:staff.edit');
    Route::post('staff/update/{id}', [StaffController::class, 'update'])->name('staff.update')->middleware('permission:staff.edit');
    Route::get('staff/index', [StaffController::class, 'index'])->name('staff.index')->middleware('permission:staff.view');
    Route::post('staff/destroy/{id}', [StaffController::class, 'destroy'])->name('staff.destroy')->middleware('permission:staff.delete');

    Route::get('shift/create', [ShiftController::class, 'create'])->name('shift.create');
    // Route::get('shift/create', [ShiftController::class, 'create'])->name('shift.create')->middleware('permission:shift.add');
    Route::post('shift/store', [ShiftController::class, 'store'])->name('shift.store');
    // Route::post('shift/store', [ShiftController::class, 'store'])->name('shift.store')->middleware('permission:shift.add');
    Route::get('shift/edit/{id}', [ShiftController::class, 'edit'])->name('shift.edit')->middleware('permission:shift.edit');
    Route::post('shift/update', [ShiftController::class, 'update'])->name('shift.update')->middleware('permission:shift.edit');
    Route::get('/get-shift-data', [ShiftController::class, 'getShiftData'])->name('get.shift.data');

    Route::get('shift/index', [ShiftController::class, 'index'])->name('shift.index')->middleware('permission:shift.view');
    Route::post('shift/destroy/{id}', [ShiftController::class, 'destroy'])->name('shift.destroy')->middleware('permission:shift.delete');

    // Route::get('staffschedule/create', [StaffScheduleController::class, 'create'])->name('staffschedule.create');
    Route::get('staffschedule/create', [StaffScheduleController::class, 'create'])->name('staffschedule.create')->middleware('permission:staffschedule.add');
    // Route::post('staffschedule/store', [StaffScheduleController::class, 'store'])->name('staffschedule.store');
    Route::post('staffschedule/store', [StaffScheduleController::class, 'store'])->name('staffschedule.store')->middleware('permission:staffschedule.add');
    Route::get('staffschedule/edit/{id}', [StaffScheduleController::class, 'edit'])->name('staffschedule.edit')->middleware('permission:staffschedule.edit');

    Route::get('/get-schedule-data', [StaffScheduleController::class, 'getSchedulData'])->name('get.schedule.data');

    Route::post('staffschedule/update', [StaffScheduleController::class, 'update'])->name('staffschedule.update')->middleware('permission:staffschedule.edit');
    Route::get('staffschedule/index', [StaffScheduleController::class, 'index'])->name('staffschedule.index')->middleware('permission:staffschedule.view');
    Route::post('staffschedule/destroy/{id}', [StaffScheduleController::class, 'destroy'])->name('staffschedule.destroy')->middleware('permission:staffschedule.delete');
});

// use for test
Route::resource('test', TryTestController::class);
require __DIR__ . '/auth.php';
