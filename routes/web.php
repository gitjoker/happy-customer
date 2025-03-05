<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RhymeSchemeController;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('home');
});

Route::get('/code-sample', function () {
    $filePath = 'code-sample.txt'; // ไฟล์ที่ใช้เก็บโค้ด
    $codeContent = Storage::exists($filePath) ? Storage::get($filePath) : "ไฟล์ไม่พบ หรือไม่มีข้อมูล";
    return view('code-sample', compact('codeContent'));
});

Route::get('/query-1', function () {
    $filePath = 'query-1.txt'; // ไฟล์ที่ใช้เก็บโค้ด
    $codeContent = Storage::exists($filePath) ? Storage::get($filePath) : "ไฟล์ไม่พบ หรือไม่มีข้อมูล";
    return view('code-sample', compact('codeContent'));
});

Route::get('/query-2', function () {
    $filePath = 'query-2.txt'; // ไฟล์ที่ใช้เก็บโค้ด
    $codeContent = Storage::exists($filePath) ? Storage::get($filePath) : "ไฟล์ไม่พบ หรือไม่มีข้อมูล";
    return view('code-sample', compact('codeContent'));
});

Route::get('/create-order', [OrderController::class, 'create'])->name('order.create');
Route::post('/store-order', [OrderController::class, 'store'])->name('order.store');

Route::get('/rhyme-scheme-validate', [RhymeSchemeController::class, 'showForm']);
Route::post('/rhyme-scheme-validate', [RhymeSchemeController::class, 'processForm']);


