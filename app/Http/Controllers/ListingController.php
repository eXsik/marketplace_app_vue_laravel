<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotSuspended;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Listing;
use App\Services\ImageService;
use App\Services\ListingService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ListingController extends Controller implements HasMiddleware
{
    protected $imageService;
    protected $listingService;

    public function __construct(ImageService $imageService, ListingService $listingService)
    {
        $this->imageService = $imageService;
        $this->listingService = $listingService;
    }

    public static function middleware()
    {
        return [
            new Middleware(['auth', 'verified', NotSuspended::class], except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listings = Listing::notSuspended()
            ->approved()
            ->with('user')
            ->filter(request(['search', 'user_id', 'tag']))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return Inertia::render('Home', ['listings' => $listings, 'searchTerm' => $request->search]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Listing::class);

        return Inertia::render('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request)
    {
        Gate::authorize('create', Listing::class);
        $fields = $request->validated();
        $user = Auth::user();

        $this->listingService->createListing($user, $fields, $request->file('image'));

        return redirect()->route('dashboard')->with('status', 'Listing created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);

        return Inertia::render(
            'Listing/Show',
            [
                'listing' => $listing,
                'user' => $listing->user->only(['name', 'id']),
                'canModify' => Auth::user() ? Auth::user()->can('modify', $listing) : false
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize('modify', $listing);

        return Inertia::render('Listing/Edit', ['listing' => $listing]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        Gate::authorize('modify', $listing);

        $fields = $request->validated();

        $this->listingService->updateListing($listing, $fields, $request->file('image'));

        return redirect()->route('dashboard')->with('status', 'Listing updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize('modify', $listing);

        $this->listingService->deleteListing($listing);

        return redirect()->route('dashboard')->with('status', 'Listing deleted successfully.');
    }
}
