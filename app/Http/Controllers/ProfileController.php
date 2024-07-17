<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Cambiar el avatar del usuario.
     */
    public function changeAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validación del archivo de imagen
        ]);

        $user = $request->user();
        $profile = $user->userProfile;

        // Eliminar el avatar anterior si existe
        if ($profile->avatar) {
            $avatarPath = public_path('assets/uploads/avatars/imgs/' . $profile->avatar);

            // Verificar si el archivo existe antes de intentar eliminarlo
            if (File::exists($avatarPath)) {
                File::delete($avatarPath);
            }
        }

        // Guardar el nuevo avatar
        $avatarName = $request->file('avatar')->getClientOriginalName();
        $request->file('avatar')->move(public_path('assets/uploads/imgs/avatars/'), $avatarName);

        // Actualizar el avatar en el perfil del usuario
        $profile->avatar = $avatarName;
        $profile->save();

        return redirect()->back()->with('status', 'Avatar actualizado correctamente.');
    }
}
