<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController;
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


Route::get('/juegos',[GameController::class, 'getGames'])->name('coleccion');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/dashboard/lista_de_juegos', [AdminController::class, 'gameList'])->name('admin.games');
    Route::get('/dashboard/lista_de_juegos/anyadir', [AdminController::class, 'addGame'])->name('admin.add-game');
    Route::get('/dashboard/usuario', [AdminController::class, 'getUsers'])->name('admin.users');
    Route::get('/dashboard/permisos', [AdminController::class, 'getPermises'])->name('admin.permises');
    Route::post('/dashboard/new_game', [AdminController::class, 'storeGame'])->name('new_game');
    Route::post('/dashboard/change-img-game', [AdminController::class, 'changeImgGame'])->name('change-img-game');
    Route::delete('/dashboard/games/{id}', [AdminController::class, 'deleteGame'])->name('delete-game');
    Route::patch('/dashboard/games/modificar-estado/{id}', [AdminController::class, 'updateActive'])->name('update-active');
    Route::patch('/dashboard/games/modificar-show-in-web/{id}', [AdminController::class, 'updateShowInWeb'])->name('update-show-in-web');
});


Route::middleware('auth')->group(function () {
    Route::get('/mi-perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mi-perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/mi-perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/change-avatar', [ProfileController::class, 'changeAvatar'])->name('profile.change-avatar');
});

require __DIR__ . '/auth.php';
