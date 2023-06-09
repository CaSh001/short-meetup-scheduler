<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\AvailabilityController;
use Illuminate\Support\Facades\Route;
use App\Models\Meeting;
use App\Models\User;

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

Route::get('/', function () {
    return view('main', [
        'numberOfUsers' => User::count(),
        'numberOfMeetings' => Meeting::count(),
        //'numberOfActiveRentals' => Borrow::where('status','=','ACCEPTED')->get()->count(),
    ]);
})->name('main');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('meetings', MeetingController::class);
Route::patch('/meetings/{meeting}/update-finalized-time', [MeetingController::class, 'updateFinalizedTime'])->name('meetings.updateFinalizedTime');

Route::get('/availabilities/create/{meeting}', [AvailabilityController::class, 'create'])->name('availabilities.create');
Route::post('/availabilities/store/{meeting}', [AvailabilityController::class, 'store'])->name('availabilities.store');

require __DIR__.'/auth.php';
