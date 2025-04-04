<?php

use App\Http\Controllers\ChoristeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactSubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return redirect()->route('partitions');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/trombinoscope', [ChoristeController::class, 'trombinoscope'])->name('trombinoscope');
    Route::get('/partitions', [ChoristeController::class, 'partitions'])->name('partitions');
    Route::get('/partitions/{song}', [ChoristeController::class, 'partition'])->name('partition');
});

require __DIR__.'/auth.php';

## CMS Pages
Route::get('{slug}', [PageController::class, 'show'])->name('page.show');
Route::get('/', [PageController::class, 'show'])->name('homepage');

Route::post('/contact-submit', [ContactSubmissionController::class, 'store'])->name('contact.submit');

