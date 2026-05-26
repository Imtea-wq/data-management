<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CargoController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('cargo', CargoController::class);
Route::get('cargo-export-pdf', [CargoController::class, 'exportPdf'])->name('cargo.export.pdf');
Route::get('cargo-export-excel', [CargoController::class, 'exportExcel'])->name('cargo.export.excel');
