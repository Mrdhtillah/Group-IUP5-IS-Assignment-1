<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataRetrievalController;

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

// Routes for Authentication
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes for Dashboard (Authenticated User)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::post('/upload/idcard', [DashboardController::class, 'uploadIDCard'])->name('upload.idcard');
    Route::post('/upload/files', [DashboardController::class, 'uploadFiles'])->name('upload.files');
    Route::post('/upload/video', [DashboardController::class, 'uploadVideo'])->name('upload.video');
});


Route::get('/data-retrieval', [DataRetrievalController::class, 'index'])->name('data.retrieval')->middleware('auth');

// Example route for storing user data
Route::post('/store-user-data', 'UserController@store')->name('store.user.data')->middleware('auth');

// Example route for retrieving user data
Route::get('/retrieve-user-data', 'UserController@show')->name('retrieve.user.data')->middleware('auth');

// Additional routes can be added as needed.
Route::get('/protected/resource', 'ProtectedController@index')->middleware('checkUserCredentials');
