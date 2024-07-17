<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/acerca-de', function () {
    return view('about');
})->name('about');

Route::get('/contacto', function () {
    return view('contact');
})->name('contact');

Route::get('/juegos/tetris_one', function () {
    return view('juegos.tetris-one');
})->name('tetris_one');

Route::get('/juegos/sudoku', function () {
    return view('juegos.sudoku');
})->name('sudoku_one');

Route::get('/juegos/memo_1', function () {
    return view('juegos.memo_1');
})->name('memo_1');

Route::get('/juegos/ajedrez', function () {
    return view('juegos.ajedrez');
})->name('ajedrez');

Route::get('/juegos/damas', function () {
    return view('juegos.damas');
})->name('damas');

Route::get('/juegos/demo_physer', function () {
    return view('juegos.demo_physer');
})->name('demo_physer');

Route::get('/juegos/bullet_game', function () {
    return view('juegos.bullet_game');
})->name('bullet_game');


Route::get('/juegos', function () {
    return view('juegos.coleccion');
})->name('coleccion');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/lista_de_juegos', function () {
    return view('admin.list');
})->middleware(['auth', 'verified'])->name('admin.list');

Route::get('/dashboard/lista_de_juegos/anyadir', function () {
    return view('admin.add');
})->middleware(['auth', 'verified'])->name('admin.add');

Route::get('/dashboard/usuarios', function () {
    return view('admin.users');
})->middleware(['auth', 'verified'])->name('admin.users');

Route::get('/dashboard/permisos', function () {
    return view('admin.permises');
})->middleware(['auth', 'verified'])->name('admin.permises');


Route::middleware('auth')->group(function () {
    Route::get('/mi-perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mi-perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/mi-perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
