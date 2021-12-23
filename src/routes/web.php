<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KmongController;
use App\Http\Controllers\MemberController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/member/login', [MemberController::class, 'login']);
Route::post('/member/logout', [MemberController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    /** #controller 주문하기 */
    Route::post('/shop/order', [KmongController::class, 'order']);

    /** #controller 주문내역 가져오기 */
    Route::get('/shop/orders', [KmongController::class, 'orderList']);
});
