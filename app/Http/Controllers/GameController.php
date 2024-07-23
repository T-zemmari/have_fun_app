<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\UserGameLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function getGames()
    {
        $games = Game::all();
        //dump($games);die;
        return view('juegos.coleccion', ['games' => $games]);
    }

    public function tetrisOne()
    {
        return view('juegos.tetris-one');
    }

    public function sudoku()
    {
        return view('juegos.sudoku');
    }

    public function memo1()
    {
        return view('juegos.memo_1');
    }

    public function ajedrez()
    {
        return view('juegos.ajedrez');
    }

    public function damas()
    {
        return view('juegos.damas');
    }

    public function demoPhyser()
    {
        return view('juegos.demo_physer');
    }

    public function bulletGame()
    {
        return view('juegos.bullet_game');
    }

    public function spaceWar()
    {
        return view('juegos.space_war');
    }

    public function treasureHunt()
    {
        return view('juegos.treasure_hunt');
    }

    public function adventureOne()
    {
        $user = Auth::user();
        $user_id = $user ? $user->id : null;
        $game = Game::whereRaw('LOWER(name) = ?', ['adventure one'])
            ->whereRaw('LOWER(route_name) = ?', ['adventure_one'])
            ->first();

        if (!$game) {
            abort(404, 'Game not found');
        }

        $gameId = $game->id;
        $gameUserLevelScoreId = null;

        if (is_numeric($user_id) && is_numeric($gameId)) {
            $gameUserLevelScore = UserGameLevel::where('user_id', $user_id)
                ->where('game_id', $gameId)
                ->first();

            if ($gameUserLevelScore) {
                $gameUserLevelScoreId = $gameUserLevelScore->id;
            } else {
                $gameUserLevelScore = new UserGameLevel();
                $gameUserLevelScore->user_id = $user_id;
                $gameUserLevelScore->game_id = $gameId;
                $gameUserLevelScore->level = 0;
                $gameUserLevelScore->score = 0;
                $gameUserLevelScore->save();

                $gameUserLevelScoreId = $gameUserLevelScore->id;
            }
        }

        return view('juegos.adventure_one', compact('gameId', 'user_id', 'gameUserLevelScoreId'));
    }
}
