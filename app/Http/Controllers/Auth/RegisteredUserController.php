<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $roles = ['ROLE_SUPERUSER', 'ROLE_USER'];
        $user_type = "user";

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name ?? '',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active' => 1,
            'roles' => json_encode($roles),
            'user_type' => $user_type,
        ]);

        $user->userProfile()->create([
            'user_id' => $user->id,
            'phone' => 'N/A',
            'adress' => 'N/A',
            'avatar' => 'N/A',
            'active' => 1,
        ]);

        event(new Registered($user));

        //Auth::login($user);

        //return redirect(RouteServiceProvider::HOME);
        return redirect('login');
    }
}
