<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model {
    protected $table = 'comment_reply';
    protected $fillable = ['id_user', 'id_comment', 'content', 'created_at'];

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    protected function getAll(){
        return $this::all();
    }

    protected function getReplyByIdComment($id){
        
    }

    protected function getReplyComnent($id){
        return $this::join("User", "comment_reply.id_user", "=", "User.id")
        ->where("comment_reply.id_comment", "like", $id)
        ->orderBy('created_at', 'desc')
        ->get(['content', 'fullname', 'avatar' ,'comment_reply.created_at']);
    }

    protected function createReply($data){
        return $this::create($data);
    }

    protected function deleteReply($id_comment){
        return $this::where('id_comment', '=', $id_comment)->delete();
    }

}