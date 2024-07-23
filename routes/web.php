<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
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
    return view('emails.contact');
})->name('contact');




Route::get('/juegos', [GameController::class, 'getGames'])->name('coleccion');
Route::post('/contact', [ContactController::class, 'sendMail'])->name('contact.send');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::prefix('juegos')->group(function () {
    Route::get('/tetris_one', [GameController::class, 'tetrisOne'])->name('tetris_one');
    Route::get('/sudoku', [GameController::class, 'sudoku'])->name('sudoku_one');
    Route::get('/memo_1', [GameController::class, 'memo1'])->name('memo_1');
    Route::get('/ajedrez', [GameController::class, 'ajedrez'])->name('ajedrez');
    Route::get('/damas', [GameController::class, 'damas'])->name('damas');
    Route::get('/demo_physer', [GameController::class, 'demoPhyser'])->name('demo_physer');
    Route::get('/bullet_game', [GameController::class, 'bulletGame'])->name('bullet_game');
    Route::get('/space_war', [GameController::class, 'spaceWar'])->name('space_war');
    Route::get('/treasure_hunt', [GameController::class, 'treasureHunt'])->name('treasure_hunt');
    Route::get('/adventure_one', [GameController::class, 'adventureOne'])->name('adventure_one');
});



Route::middleware('auth')->group(function () {

    Route::get('/dashboard/lista_de_juegos', [AdminController::class, 'gameList'])->name('admin.games');
    Route::get('/dashboard/lista_de_juegos/anyadir', [AdminController::class, 'addGame'])->name('admin.add-game');
    Route::get('/dashboard/usuario', [AdminController::class, 'getUsers'])->name('admin.users');
    Route::get('/dashboard/permisos', [AdminController::class, 'getPermises'])->name('admin.permises');


    Route::post('/dashboard/new_game', [AdminController::class, 'storeGame'])->name('new_game');
    Route::post('/dashboard/change-img-game/{id}', [AdminController::class, 'changeImgGame'])->name('change-img-game');
    Route::post('/dashboard/save-level-score/', [AdminController::class, 'saveLevelAndScore'])->name('save-level-score');


    Route::patch('/dashboard/games/modificar-estado/{id}', [AdminController::class, 'updateActive'])->name('update-active');
    Route::patch('/dashboard/games/modificar-show-in-web/{id}', [AdminController::class, 'updateShowInWeb'])->name('update-show-in-web');
    Route::patch('/dashboard/games/modificar-free-or-paid/{id}', [AdminController::class, 'updateFreeOrPaid'])->name('update-free-or-paid');
    Route::patch('/dashboard/edit-level-score/', [AdminController::class, 'editLevelAndScore'])->name('edit-level-score');

    Route::delete('/dashboard/games/{id}', [AdminController::class, 'deleteGame'])->name('delete-game');
    Route::delete('/dashboard/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('delete-user');
});


Route::middleware('auth')->group(function () {
    Route::get('/mi-perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mi-perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/mi-perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/change-avatar', [ProfileController::class, 'changeAvatar'])->name('profile.change-avatar');
});

require __DIR__ . '/auth.php';
