<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\VotingResult;
use DB;
use URL;

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
        return view('home');
    }

    public function getFoodList() {

        $totalVotes = 0;
        $foodList = \App\Item::all()->toArray();
        $VoteList = VotingResult::all()->toArray();
        $VoteList = DB::table('voting_results')
                        ->select(DB::raw('count(*) as item_count, item_id'))
                        ->groupBy('item_id')
                        ->get()->keyBy('item_id')->toArray();
        foreach ($VoteList as $key => $value) {
            $totalVotes += $value->item_count;
        }
        foreach ($foodList as $key => $foodItem) {
            if (array_key_exists($foodItem['id'], $VoteList)) {
                $foodList[$key]['percent'] = round(($VoteList[$foodItem['id']]->item_count * 100) / $totalVotes, 2);
            } else {
                $foodList[$key]['percent'] = 0;
            }
            $foodList[$key]['img_url'] = URL::to('/') .'/'. $foodList[$key]['img_url'];
        }
        return $foodList;
    }

    public function giveVote(Request $request) {
        $foodID = $request->input('selectedFood');
        $voting = VotingResult::firstOrCreate(['user_id' => Auth::user()->id], ['item_id' => $foodID]);
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
