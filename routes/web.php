<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/forget', [UserController::class, 'forget']);
Route::get('/register', [UserController::class, 'register']);
Route::get('/reset', [UserController::class, 'reset']);
Route::post('/register', [UserController::class, 'saveUser'])->name('auth.register');
Route::post('/login', [UserController::class, 'login'])->name('auth.login');

Route::group(['middleware' => ['LoginCheck']], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/logout', [UserController::class, 'logout'])->name('auth.logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile-image', [UserController::class, 'profileImageUpdate'])->name('profile.image');

    Route::post('/profile-update', [UserController::class, 'profileupdate'])->name('profile.update');
});