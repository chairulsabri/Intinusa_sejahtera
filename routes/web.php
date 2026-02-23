<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Models\Barang;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $stats = Barang::select('kategori', \DB::raw('SUM(harga) as total_harga'))
        ->groupBy('kategori')
        ->get();

    $barangs = Barang::all(); // Requirement says "Tampilan data barang di dashboard"

    return view('dashboard', compact('stats', 'barangs'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('barang', BarangController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
