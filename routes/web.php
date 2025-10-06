<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/policies', function () {
    return view('policies');
})->name('policies');
Route::view('/terms', 'terms')->name('terms');
Route::view('/copyright', 'copyright')->name('copyright');
Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/partner', function () {
    return view('partner');
})->name('partner');
Route::get('/driver', function () {
    return view('driver');
})->name('driver');
Route::get('/about', function () {
    return view('about');
})->name('about');
