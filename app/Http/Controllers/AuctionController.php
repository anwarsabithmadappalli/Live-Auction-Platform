<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AuctionController extends Controller
{

    use AuthorizesRequests;
    
    public function Index()
    {
        return Inertia::render('Auctions/Index', [
        'is_admin' => Gate::allows('is_admin'),
        ]);
    }

    public function list()
    {
        $auctions = Auction::withCount('bids')->latest()->get();
        
        return response()->json($auctions);
    }

    public function create()
    {
        return Inertia::render('Auctions/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'starting_price' => 'required|numeric|min:0',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
        ]);

        $data['user_id'] = Auth::id();
        $data['current_price'] = $data['starting_price'];

        Auction::create($data);

        return redirect()->route('auctions.Index')->with('success', 'Auction created successfully.');
    }

    public function show($id)
    {
        
        $auction = Auction::with('bids.user', 'user')->findOrFail($id);

        return Inertia::render('Auctions/Show', [
            'auction' => $auction
        ]);
    }

    public function edit($id)
    {

        $auction = Auction::findOrFail($id);

        return Inertia::render('Auctions/Edit', [
            'auction' => $auction
        ]);
    }

    public function update(Request $request, Auction $auction)
    {

        if (auth()->id() !== $auction->user_id) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'starting_price' => 'required|numeric|min:0',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'status' => 'in:upcoming,live,ended'
        ]);

        $auction->update($data);

        return redirect()->route('auctions.Index')->with('success', 'Auction updated.');
    }

    public function destroy(Auction $auction)
    {
        $auction->delete();

        return redirect()->route('auctions.Index')->with('success', 'Auction deleted.');
    }
}
