<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\VotingResult;
use DB;
use URL;

class HomeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('home');
    }

//  ******************** Get List of Food Item with their respective votes ********************
    public function getFoodList() {
        $totalVotes = 0;
        $foodList = \App\Item::all()->toArray();
        $VoteList = VotingResult::all()->toArray();
        $VoteList = DB::table('voting_results')
                        ->select(DB::raw('count(*) as item_count, item_id'))
                        ->groupBy('item_id')
                        ->get()->keyBy('item_id')->toArray();
        foreach ($VoteList as $key => $voteItem) {
            $totalVotes += $voteItem->item_count;
        }
        foreach ($foodList as $key => $foodItem) {
            if (array_key_exists($foodItem['id'], $VoteList)) {
                $foodList[$key]['percent'] = round(($VoteList[$foodItem['id']]->item_count * 100) / $totalVotes, 2);
                $foodList[$key]['totalVoteGiven'] = $VoteList[$foodItem['id']]->item_count;
            } else {
                $foodList[$key]['percent'] = 0;
                $foodList[$key]['totalVoteGiven'] = 0;
            }
            $foodList[$key]['img_url'] = URL::to('/') .'/'. $foodList[$key]['img_url'];
            
        }
        
//      ***************************** Sort array by number of votes *******************************
        $totalVoteArray = array();
        foreach ($foodList as $key => $row)
        {
            $totalVoteArray[$key] = $row['totalVoteGiven'];
        }
        array_multisort($totalVoteArray, SORT_DESC, $foodList);
        
        return $foodList;
    }

//  ******************** Insert Vote ********************
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
