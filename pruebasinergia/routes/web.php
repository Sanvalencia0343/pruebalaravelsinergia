<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('users.index');
    } else {
        return view('welcome');
    }
})->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name('users.index');
    Route::post('/{id}/changestatus', [UserController::class, 'changestatus'])->name('users.changestatus');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::post('/', [AuthController::class, 'login'])->name('users.login');
Route::get('welcome', [AuthController::class, 'logout'])->name('users.logout');
Route::get('/register', [UserController::class, 'create'])->name('users.create');
Route::post('/register', [UserController::class, 'store'])->name('users.store');
