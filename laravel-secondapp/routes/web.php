<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Group Admin Middleware
Route::middleware(['auth','role:admin'])->group(function(){ //Check Login? and Role is Admin?

    //Show Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'admin_dashboard'])->name('admin.admin_dashboard');

    //Admin Logout
    Route::get('/admin/logout', [AdminController::class, 'admin_logout'])->name('admin.logout'); //->name ตังชื่อ route สำหรับไปใช้กับ tag ahref {{route('name')}}

    //Show Edit Profile Admin
    Route::get('/admin/profile', [AdminController::class, 'admin_profile'])->name('admin.profile');

    //Update Admin Profile
    Route::post('/admin/profile.store', [AdminController::class, 'admin_profile_store'])->name('admin.profile.store');

    //Show Change Password Page
    Route::get('admin/change/password', [AdminController::class, 'admin_change_password'])->name('admin.change.password');

    //Update Admin Password
    Route::post('admin/update/password', [AdminController::class, 'admin_update_password'])->name('admin.update.password');
});


//Group Agent Middleware
Route::middleware(['auth','role:agent'])->group(function(){ //Check Login? and Role is Agent?
Route::get('/agent/dashboard', [AgentController::class, 'agent_dashboard'])->name('agent.agent_dashboard');
});


//Show Admin Login Form
Route::get('/admin/login', [AdminController::class, 'admin_login'])->name('admin.login');
