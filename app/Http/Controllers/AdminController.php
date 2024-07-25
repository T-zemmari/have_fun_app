<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\UserGameLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class AdminController extends Controller
{
    public function getUsers()
    {

        $users = User::with('userProfile')->get();
        // dump($users);die;

        return view('admin.users', ['users' => $users]);
    }

    public function gameList()
    {
        $games = Game::all();
        return view('admin.games', ['games' => $games]);
    }

    public function addGame()
    {
        return view('admin.add-game');
    }

    public function storeGame(Request $request)
    {
        // Validaciones + evitar duplicados
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'route_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('games')->where(function ($query) use ($request) {
                    return $query->where('route_name', $request->route_name);
                }),
            ],
            'url_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'active' => 'required|boolean',
            'free_or_paid' => 'required|boolean',
            'show_in_web' => 'required|boolean',
        ]);

        $imagePath = 'assets/uploads/imgs/games';
        $imageName = time() . '_' . $request->file('url_img')->getClientOriginalName();

        // Crear el directorio si no existe
        if (!File::exists(public_path($imagePath))) {
            File::makeDirectory(public_path($imagePath), 0755, true);
        }

        // Guardar la imagen
        $request->file('url_img')->move(public_path($imagePath), $imageName);

        // Crear el juego
        $game = new Game();
        $game->name = $request->input('name');
        $game->description = $request->input('description');
        $game->route_name = $request->input('route_name');
        $game->url_img = '/' . $imagePath . '/' . $imageName;
        $game->active = $request->boolean('active') ? 1 : 0;
        $game->free_or_paid = $request->boolean('free_or_paid') ? 1 : 0;
        $game->show_in_web = $request->boolean('show_in_web') ? 1 : 0;

        // Guardar el juego si pasa todas las validaciones
        $game->save();

        return redirect()->route('admin.games')->with('success', 'Juego creado exitosamente.');
    }


    public function updateActive($id, Request $request)
    {
        try {
            $game = Game::findOrFail($id);
            $game->active = $request->input('active') ? true : false;
            $game->save();
            return response()->json(['message' => 'Estado actualizado correctamente'], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'code' => 422,
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function updateShowInWeb($id, Request $request)
    {
        try {
            $game = Game::findOrFail($id);
            $game->show_in_web = $request->input('show_in_web') ? true : false;
            $game->save();
            return response()->json(['message' => 'Estado actualizado correctamente'], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'code' => 422,
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function updateFreeOrPaid($id, Request $request)
    {
        try {
            $game = Game::findOrFail($id);
            $game->free_or_paid = $request->input('free_or_paid') ? true : false;
            $game->save();
            return response()->json(['message' => 'Free Or Paid actualizado correctamente'], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'code' => 422,
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function changeImgGame(Request $request, $id)
    {

        try {
            $request->validate([
                'image_game' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10000'],
            ]);

            $game = Game::findOrFail($id);

            if ($game->url_img) {
                $imagePath = public_path('assets/uploads/imgs/games/' . $game->url_img);

                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $imageName = $request->file('image_game')->getClientOriginalName();
            $request->file('image_game')->move(public_path('assets/uploads/imgs/games/'), $imageName);

            $game->url_img = '/assets/uploads/imgs/games/' . $imageName;
            $game->save();

            return response()->json(['message' => 'Imagen actualizada correctamente.']);
        } catch (ValidationException $e) {
            return response()->json([
                'code' => 422,
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function deleteGame($id)
    {
        $game = Game::findOrFail($id);

        if ($game->url_img) {
            $imagePath = public_path('assets/uploads/imgs/games/' . $game->url_img);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $game->delete();

        return redirect()->route('admin.games')->with('success', 'Juego eliminado exitosamente.');
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->id === Auth::id()) {
                throw new \Exception('No puedes eliminar tu propia cuenta.', 403);
            }

            if ($user->userProfile) {
                if ($user->userProfile->avatar && $user->userProfile->avatar != 'N/A') {
                    $avatarPath = public_path('assets/uploads/imgs/avatars/' . $user->userProfile->avatar);
                    if (File::exists($avatarPath)) {
                        File::delete($avatarPath);
                    }
                }
                $user->userProfile->delete();
            }

            $user->delete();

            return response()->json(['message' => 'Usuario eliminado correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(), // Use the exception message directly
            ], 500);
        }
    }



    public function getPermises()
    {
        return view('admin.permises');
    }


    public function saveLevelAndScore(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $gameLevelScore = new UserGameLevel();
            $gameLevelScore->user_id = $request->input('user_id');
            $gameLevelScore->user_id = $request->input('game_id');
            $gameLevelScore->level = $request->input('level');
            $gameLevelScore->score = $request->input('score');
            $gameLevelScore->save();

            return response()->json(['message' => 'Nivel + Score guardados correctamente']);
        }

        return response()->json(['message' => 'El usuario de no esta logeado'], 401);
    }

    public function genPositions()
    {
        return view('admin.gen_pos');
    }
}
