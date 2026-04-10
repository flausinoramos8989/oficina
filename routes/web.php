<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BillController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [SiteController::class, 'index'])->name('site.index');

// Auth
Route::get('/admin/login', fn() => view('admin.login'))->name('admin.login')->middleware('guest');
Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }
    return back()->withErrors(['email' => 'Credenciais inválidas.']);
})->name('admin.login.post');

Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    return redirect()->route('admin.login');
})->name('admin.logout');

// Admin — qualquer usuário autenticado
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/settings', [AdminController::class, 'settingsEdit'])->name('settings.edit');
    Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');

    Route::get('/banners', [AdminController::class, 'bannersIndex'])->name('banners.index');
    Route::get('/banners/create', [AdminController::class, 'bannersCreate'])->name('banners.create');
    Route::post('/banners', [AdminController::class, 'bannersStore'])->name('banners.store');
    Route::get('/banners/{banner}/edit', [AdminController::class, 'bannersEdit'])->name('banners.edit');
    Route::post('/banners/{banner}', [AdminController::class, 'bannersUpdate'])->name('banners.update');
    Route::delete('/banners/{banner}', [AdminController::class, 'bannersDestroy'])->name('banners.destroy');

    Route::get('/services', [AdminController::class, 'servicesIndex'])->name('services.index');
    Route::get('/services/create', [AdminController::class, 'servicesCreate'])->name('services.create');
    Route::post('/services', [AdminController::class, 'servicesStore'])->name('services.store');
    Route::get('/services/{service}/edit', [AdminController::class, 'servicesEdit'])->name('services.edit');
    Route::post('/services/{service}', [AdminController::class, 'servicesUpdate'])->name('services.update');
    Route::delete('/services/{service}', [AdminController::class, 'servicesDestroy'])->name('services.destroy');

    // Contas a pagar
    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
    Route::get('/bills/create', [BillController::class, 'create'])->name('bills.create');
    Route::post('/bills', [BillController::class, 'store'])->name('bills.store');
    Route::get('/bills/{bill}/edit', [BillController::class, 'edit'])->name('bills.edit');
    Route::post('/bills/{bill}', [BillController::class, 'update'])->name('bills.update');
    Route::delete('/bills/{bill}', [BillController::class, 'destroy'])->name('bills.destroy');
    Route::post('/bills/occurrence/{occurrence}/pay', [BillController::class, 'payOccurrence'])->name('bills.occurrence.pay');
    Route::post('/bills/single/{bill}/pay', [BillController::class, 'paySingle'])->name('bills.single.pay');

    // Somente admin pode gerenciar usuários
    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
