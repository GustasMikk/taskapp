<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/tasks', function () {
    return view('tasks');
})->name('tasks');
