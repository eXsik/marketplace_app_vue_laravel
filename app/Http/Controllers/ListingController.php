<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Listing;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ListingController extends Controller
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
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
        return Inertia::render('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request)
    {

        $fields = $request->validated();

        if ($request->hasFile('image')) {
            $fields['image'] = $this->imageService->upload($request->image, 'images/listing');
        }

        $fields['tags'] = Listing::processTags($request->tags);

        $request->user()->listings()->create($fields);

        return redirect()->route('dashboard')->with('status', 'Listing created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        return Inertia::render('Listing/Show', ['listing' => $listing, 'user' => $listing->user->only(['name', 'id'])]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return Inertia::render('Listing/Edit', ['listing' => $listing]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $fields = $request->validated();

        if ($request->hasFile('image')) {

            if ($listing->image) {
                $this->imageService->delete($listing->image);
            }

            $fields['image'] = $this->imageService->upload($request->image, 'images/listing');
        } else {
            $fields['image'] = $listing->image;
        }

        $fields['tags'] = $listing->processTags($request->tags);

        $listing->update($fields);

        return redirect()->route('dashboard')->with('status', 'Listing updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        if ($listing->image) {
            $this->imageService->delete($listing->image);
        }

        $listing->delete();

        return redirect()->route('dashboard')->with('status', 'Listing deleted successfully.');
    }
}
