<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRoleRequest;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function index(): Response
    {
        $users = User::with('listings')
            ->filter(request(['search', 'user_role']))
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/AdminDashboard', ['users' => $users, 'status' => session('status')]);
    }

    public function show(User $user)
    {
        $user_listings = $user->listings()->filter(request(['search', 'disapproved']))->latest()->paginate(6)->withQueryString();

        return Inertia::render('Admin/UserPage', [
            'user' => $user,
            'listings' => $user_listings,
            'status' => session('status')
        ]);
    }

    public function role(UserUpdateRoleRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('modifyRole', $user);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.index')->with('status', "User role changed to {$request->role} successfully");
    }

    public function approve(Listing $listing)
    {
        Gate::authorize('approve', $listing);

        $listing->update(['approved' => !$listing->approved]);
        $msg = $listing->approved ? 'approved' : 'disapproved';

        return back()->with('status', "Listing {$msg} successfully!");
    }
}