<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function getGames()
    {
        $games = Game::all();
        //dump($games);die;
        return view('juegos.coleccion', ['games' => $games]);
    }
}
