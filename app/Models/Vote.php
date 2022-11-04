<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {
    protected $table = 'vote';
    protected $fillable = ['star', 'comment', 'id_user', 'id_product', 'created_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    protected function getAll(){
        return Vote::all();
    }

    protected function createVote($vote){
        return Vote::create($vote);
    }

    protected function getVoteByIdProduct($id){
        return Vote::orderBy('created_at', 'DESC')
        ->where("id_product", "=", $id)
        ->get();
    }

    protected function getInfoUserOfVote($id_product){
        return Vote::join("User", "vote.id_user", "=", "User.id")
        ->where("vote.id_product", "like", $id_product)
        ->get(['star', 'comment', 'fullname', 'vote.created_at', 'avatar']);
    }

    protected function getTop5($id_product){
        return Vote::join("User", "vote.id_user", "=", "User.id")
        ->where("vote.id_product", "like", $id_product)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get(['star', 'comment', 'fullname', 'vote.created_at', 'avatar']);
    }

    protected function averagedStar($id_product){
        $num = Vote::where("id_product", "=", $id_product)->count();
        return Vote::where("id_product", "=", $id_product)->sum('star')/
        ( $num == 0 ? 1 : $num );
    }
    
    protected function quatityVote($id_product){
        return Vote::where("id_product", "=", $id_product)->count();
    }
}