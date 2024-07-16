<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/gallery', [GalleryController::class, 'showGallery'])
    ->name('gallery');

Route::get('/gallery/album/{id}', [GalleryController::class, 'showAlbum'])
    ->name('gallery.show-album');

Route::get('/search', [GalleryController::class, 'showGallery'])
    ->name('search');

Route::get('/event', [HomeController::class, 'akce'])
    ->name('akce');

Route::get('/submitted-pictures', [HomeController::class, 'submittedPictures'])
    ->name('profile.photos');

Route::get('/submitted-reports', [HomeController::class, 'submittedReports'])
    ->name('profile.reports');

Route::get('/show-report/{id}', [HomeController::class, 'showReport'])
    ->name('reports.show');

Route::get('/report-content', [HomeController::class, 'reportContent'])
    ->name('report.now');

Route::get('/subscribes', [HomeController::class, 'subscribeNotification'])
    ->name('notification.subscribes');

Route::get('/event/{eventId}/mark-interest', [HomeController::class, 'markInterested'])
    ->name('event.interest');

Route::get('/link-account', [HomeController::class, 'linkAccount'])
    ->name('link-account');

Route::post('/link-telegram', [HomeController::class, 'linkTelegram'])
    ->name('link-telegram');

Route::get('/unlink-telegram', [HomeController::class, 'unlinkTelegram'])
    ->name('unlink-telegram');

Route::get('/logout', [HomeController::class, 'logout'])
    ->name('profile.logout');

Route::middleware(['auth', 'throttle:10,60'])->post('/report', [HomeController::class, 'pushReport'])
    ->name('report.push');

// health check
Route::get('/health', function ($request) {
    return response()->json([
        'status' => 'ok'
    ]);
});
