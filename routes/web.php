<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

// Route to list files
Route::get('/list-files', [ImageController::class, 'showFiles'])->name('list.files');

// Route to process files (upload and generate thumbnails)
Route::post('/process-files', [ImageController::class, 'processFiles'])->name('process.files');
