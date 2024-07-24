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
        $score = 0;
        $currentLevel = 0;

        if (is_numeric($user_id) && is_numeric($gameId)) {
            $gameUserLevelScore = UserGameLevel::where('user_id', $user_id)
                ->where('game_id', $gameId)
                ->first();

            if ($gameUserLevelScore) {
                $gameUserLevelScoreId = $gameUserLevelScore->id;
                $score = $gameUserLevelScore->score;
                $currentLevel = $gameUserLevelScore->level;
                $score = $gameUserLevelScore->score;
                $currentLevel = $gameUserLevelScore->level;
            } else {
                $gameUserLevelScore = new UserGameLevel();
                $gameUserLevelScore->user_id = $user_id;
                $gameUserLevelScore->game_id = $gameId;
                $gameUserLevelScore->level = 0;
                $gameUserLevelScore->score = 0;
                $gameUserLevelScore->save();

                $gameUserLevelScoreId = $gameUserLevelScore->id;
                $score = $gameUserLevelScore->score;
                $currentLevel = $gameUserLevelScore->level;
            }
        }

        return view('juegos.adventure_one', compact('gameId', 'user_id', 'gameUserLevelScoreId', 'score', 'currentLevel'));
    }

    public function updateGameLevelScore(Request $request)
    {
        $request->validate([
            'game_id' => 'required|integer',
            'level' => 'required|integer',
            'score' => 'required|integer',
        ]);

        $user = Auth::user();
        $user_id = $user ? $user->id : null;
        $game_id = $request->input('game_id');
        $level = $request->input('level');
        $score = $request->input('score');

        if ($user_id) {
            $gameUserLevelScore = UserGameLevel::where('user_id', $user_id)
                ->where('game_id', $game_id)
                ->first();

            if ($gameUserLevelScore) {
                $gameUserLevelScore->level = $level;
                $gameUserLevelScore->score = $score;
                $gameUserLevelScore->save();

                return response()->json(['message' => 'Datos actualizados correctamente.'], 200);
            }
        }

        return response()->json(['message' => 'No se encontraron datos para actualizar.'], 404);
    }
}
