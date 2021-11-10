<?php

use App\Http\Controllers\ProfilesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard', ['userName' => auth()->user()->name]);
})->name('dashboard');

// Route::middleware(['auth:sanctum', 'verified'])->apiResource('/profiles', ProfilesController::class);
//create와 edit는 제외하고 만들어줌

Route::middleware(['auth:sanctum', 'verified'])->get('/profiles/{name}', [ProfilesController::class, 'index']);
