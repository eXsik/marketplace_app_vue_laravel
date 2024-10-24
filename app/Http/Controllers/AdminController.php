<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRoleRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use function Laravel\Prompts\search;

class AdminController extends Controller
{
    public function index(): Response
    {
        $users = User::with('listings')->filter(request(['search']))->paginate(10)->withQueryString();

        return Inertia::render('Admin/AdminDashboard', ['users' => $users, 'status' => session('status')]);
    }

    public function role(UserUpdateRoleRequest $request, User $user): RedirectResponse
    {
        $user->update(['role' => $request->role]);

        return redirect()->route('admin.index')->with('status', "User role changed to {$request->role} successfully");
    }
}
