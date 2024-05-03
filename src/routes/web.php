<?php

use App\Http\Controllers\HomeController;
use App\Models\PostsComments;
use App\Models\PostsLikes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use function App\Models\PostsLikes;

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

// Main page

Route::get('/', [HomeController::class, 'outings'])
    ->name('outings');

Route::get('/online-events', [HomeController::class, 'onlineEvents'])
    ->name('online-events');

Route::get('/event', [HomeController::class, 'akce']);

Route::middleware('auth')
    ->get('/profile', [HomeController::class, 'profile'])
    ->name('profile.general');

Route::middleware('auth')
    ->get('/submitted-pictures', [HomeController::class, 'submittedPictures'])
    ->name('profile.photos');

Route::middleware('auth')
    ->get('/submitted-reports', [HomeController::class, 'submittedReports'])
    ->name('profile.reports');

Route::middleware('auth')
    ->get('/logout', [HomeController::class, 'logout'])
    ->name('profile.logout');

// health check
Route::get('/health', function ($request) {
    return response()->json([
        'status' => 'ok'
    ]);
});
