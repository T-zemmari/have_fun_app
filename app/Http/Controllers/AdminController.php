<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

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
            'url_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'required|boolean',
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
        $game->show_in_web = $request->boolean('show_in_web') ? 1 : 0;

        // Guardar el juego si pasa todas las validaciones
        $game->save();

        return redirect()->route('admin.games')->with('success', 'Juego creado exitosamente.');
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


    public function getPermises()
    {
        return view('admin.permises');
    }
}
