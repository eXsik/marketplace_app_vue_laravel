<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
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

        // Send verification email
        // TODO

        Auth::login($user);

        return redirect()->route('home');
    }
}
