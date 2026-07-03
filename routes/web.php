<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponController;

Route::get('/', function () {
    return view('index');
});
Route::post('/generate-coupon', [CouponController::class, 'generate'])->name('generate.coupon');
Route::get('/coupons/report', [CouponController::class, 'report'])->name('coupons.report');
