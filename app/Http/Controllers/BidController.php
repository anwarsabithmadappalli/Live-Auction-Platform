<?php

namespace App\Http\Controllers;

use App\Events\BidPlaced;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store(Request $request)
    {
        $bid = Bid::create([
            'auction_id' => $request->auction_id,
            'user_id' => Auth::id(),
            'amount' => $request->amount,
        ]);
        
        $auction = Auction::find($request->auction_id);
        $auction->current_price = $request->amount;
        $auction->save();

        $user = User::find(Auth::id());

        broadcast(new BidPlaced($bid, $auction, $user));
        return response()->json($bid);
    }
}
