<?php

use App\Http\Controllers\Admin\CourseAdminController;
use App\Http\Controllers\Admin\ReservationReviewController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Courses\CourseController;
use App\Http\Controllers\Reservations\ReservationController;
use App\Http\Controllers\Spaces\SpaceController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

/*
| 共用：帳號
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
| 模組一：管院空間查詢（不須登入）
*/
Route::get('/spaces', [SpaceController::class, 'index'])->name('spaces.index');
Route::get('/spaces/map', [SpaceController::class, 'map'])->name('spaces.map');
Route::get('/spaces/{room}', [SpaceController::class, 'show'])->name('spaces.show');

Route::middleware('auth')->group(function () {
    /*
    | 模組二：空間/物品預約借用（登入）
    */
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/week', [ReservationController::class, 'week'])->name('reservations.week');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    /*
    | 模組三：志願排課（老師、管理員）
    */
    Route::middleware('role:teacher,admin')->group(function () {
        Route::get('/courses/calendar', [CourseController::class, 'calendar'])->name('courses.calendar');
        Route::resource('courses', CourseController::class)->except('show');
    });

    /*
    | 管理員
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // 共用：帳號審核
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

        // 模組一：教室資料管理
        Route::resource('rooms', RoomController::class)->except('show');

        // 模組二：預約審核、借出、歸還
        Route::get('/reservations', [ReservationReviewController::class, 'index'])->name('reservations.index');
        Route::patch('/reservations/{reservation}/review', [ReservationReviewController::class, 'review'])->name('reservations.review');
        Route::patch('/reservations/{reservation}/checkout', [ReservationReviewController::class, 'checkout'])->name('reservations.checkout');
        Route::patch('/reservations/{reservation}/return', [ReservationReviewController::class, 'return'])->name('reservations.return');

        // 模組三：課程管理
        Route::get('/courses', [CourseAdminController::class, 'index'])->name('courses.index');
        Route::get('/courses/conflicts', [CourseAdminController::class, 'conflicts'])->name('courses.conflicts');
        Route::patch('/courses/{course}/move', [CourseAdminController::class, 'move'])->name('courses.move');
    });
});
