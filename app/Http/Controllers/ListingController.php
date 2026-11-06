<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotSuspended;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Listing;
use App\Services\ListingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ListingController extends Controller implements HasMiddleware
{
    public function __construct(private readonly ListingService $listingService) {}

    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'verified', NotSuspended::class], except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $listings = Listing::notSuspended()
            ->approved()
            ->with('user')
            ->filter($request->only(['search', 'user_id', 'tag']))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return Inertia::render('Home', ['listings' => $listings, 'searchTerm' => $request->search]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', Listing::class);

        return Inertia::render('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request): RedirectResponse
    {
        $fields = $request->validated();
        /** @var \App\Models\User $user */
        $user = $request->user();

        $this->listingService->createListing($user, $fields, $request->file('image'));

        return redirect()->route('dashboard')->with('status', 'Listing created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing): Response
    {
        Gate::authorize('view', $listing);

        return Inertia::render(
            'Listing/Show',
            [
                'listing' => $listing,
                'user' => $listing->user->only(['name', 'id']),
                'canModify' => Auth::user() ? Auth::user()->can('modify', $listing) : false,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing): Response
    {
        Gate::authorize('modify', $listing);

        return Inertia::render('Listing/Edit', ['listing' => $listing]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing): RedirectResponse
    {
        $fields = $request->validated();

        $this->listingService->updateListing($listing, $fields, $request->file('image'));

        return redirect()->route('dashboard')->with('status', 'Listing updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing): RedirectResponse
    {
        Gate::authorize('modify', $listing);

        $this->listingService->deleteListing($listing);

        return redirect()->route('dashboard')->with('status', 'Listing deleted successfully.');
    }
}
