<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('admin.games');
    }

    public function addGame()
    {
        return view('admin.add-game');
    }

    public function getPermises()
    {
        return view('admin.permises');
    }
}
