<?php

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

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

Route::get('/', function (): View {
    return view('welcome');
})->name('welcome');

Route::resource('domain', 'DomainController')->only(['index', 'store', 'show'])->parameters([
    'domain' => 'id'
]);
Route::resource('domain.check', 'DomainCheckController')->only(['store']);
