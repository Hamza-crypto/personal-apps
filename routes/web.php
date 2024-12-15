<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MeterReadingController;

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

Route::get('test-server', function () {
    dump('Correct Server');
});


Route::get('migrate_fresh', function () {
    Artisan::call('migrate:fresh');
    dump('Database Reset Successfully');
});


Route::get('migrate', function () {
    Artisan::call('migrate');
    dump('Migration Done');
});


Route::get('optimize', function () {
    Artisan::call('optimize:clear');
    dump('Optimization Done');
});

Route::get('storage-link', function () {
    $target = storage_path('app/public');
    $linkfolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($target, $linkfolder);

    dump($target, $linkfolder);

    dump('Link Created');
});



require __DIR__.'/auth.php';

Route::get('/send-test-email', function () {
    $details = [
        'title' => 'Test Email from Laravel',
        'body' => 'This is a test email sent using Hostinger SMTP settings in Laravel.'
    ];

    Mail::to('noorareesha162@gmail.com')->send(new \App\Mail\TestMail($details));

    return 'Email Sent!';
});

Route::get('/download-images', function () {

    Artisan::call('images:download');

});


/**
 * Meter Reading
 */

 Route::get('/graph', [MeterReadingController::class, 'showElectricityGraph'])->name('electricity-graph');

Route::get('/last-billed-reading', [MeterReadingController::class, 'showLastBilledReadingForm'])->name('last-billed-reading-form');
Route::post('/last-billed-reading', [MeterReadingController::class, 'storeLastBilledReading'])->name('store-last-billed-reading');

Route::get('/meter-reading', [MeterReadingController::class, 'showMeterReadingForm'])->name('meter-reading-form');
Route::post('/meter-reading', [MeterReadingController::class, 'storeMeterReading'])->name('store-meter-reading');

Route::get('/meter-readings/{meterName}', [MeterReadingController::class, 'getMeterReadings']);
Route::put('/meter-readings/{id}', [MeterReadingController::class, 'update'])->name('update-meter-reading');
Route::delete('/meter-readings/{id}', [MeterReadingController::class, 'destroy']);

Route::get('/send_reading', function () {
    Artisan::call('send-meter-reading');

});
