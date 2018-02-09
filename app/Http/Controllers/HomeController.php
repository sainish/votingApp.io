<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $mostInvest = \App\Item::all()->toArray();
//        print_r($mostInvest);
        return view('home')->with('data', $mostInvest);
    }

    public function getFoodList() {
        return \App\Item::all();
    }

    public function giveVote(Request $request) {
        $food_id = $request->input('selectedFood');
        $voting = \App\VotingResult::firstOrCreate(['user_id' => Auth::user()->id], ['item_id' => $food_id]);
        if ($voting->wasRecentlyCreated) {
            return array('status' => "created");
        } else {
            $vote = \App\Item::where('id', '=', $voting->item_id)->get();
            $votecustom = collect(['status' => "exist"]);
            $vote = $votecustom->merge($vote);
            return $vote;
        }
    }

}
