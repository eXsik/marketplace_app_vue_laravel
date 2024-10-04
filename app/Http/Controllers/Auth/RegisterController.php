<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterStoreRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(RegisterStoreRequest $request)
    {
        $credentials = $request->validated();
        $user = User::create($credentials);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
