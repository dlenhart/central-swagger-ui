<?php

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

Route::get( '/', [App\Http\Controllers\HomeController::class, 'index'] )->name( 'home' );
Route::get('/health', [App\Http\Controllers\HomeController::class, 'healthz'])->name('app.health');

Route::get( 'api/config', [App\Http\Controllers\SwaggerController::class, 'getSwaggerDocuments'] )->name( 'docs' );
Route::get( 'api/config/{id}', [App\Http\Controllers\SwaggerController::class, 'getSwaggerDocument'] )->name( 'doc' );
Route::get( 'api/proxy/{id}', [App\Http\Controllers\SwaggerController::class, 'proxySwaggerDocument'] )->name( 'doc_proxy' );

Route::get('admin', [App\Http\Controllers\Admin\AdminController::class, 'admin'] )->name( 'admin' )->middleware('auth');
Route::get('api/admin/list', [App\Http\Controllers\Admin\AdminApiController::class, 'list'] )->name( 'list' );
Route::post('admin/create', [App\Http\Controllers\Admin\AdminApiController::class, 'store'] )->name( 'admin.store' );
Route::post('admin/update', [App\Http\Controllers\Admin\AdminApiController::class, 'update'] )->name( 'admin.update' );
Route::post('admin/delete', [App\Http\Controllers\Admin\AdminApiController::class, 'delete'] )->name( 'admin.delete' );

Auth::routes();

