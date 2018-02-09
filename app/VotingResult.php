<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VotingResult extends Model
{
    //
    protected $fillable = ["user_id","item_id"];
}
