<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    protected $table = 'comment';
    protected $fillable = ['id','id_user', 'id_product', 'content', 'created_at', 'updated_at'];

    public function replys()
    {
        return $this->hasMany('App\Models\CommentReply');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    protected function getAll(){
        return $this::all();
    }

    protected function getCommentOfProduct($id_product){
        return Comment::join("User", "Comment.id_user", "=", "User.id")
        ->where("Comment.id_product", "like", $id_product)
        ->orderBy('created_at', 'desc')
        ->get(['Comment.id','content','User.id as id_user', 'fullname', 'avatar', 'Comment.created_at']);
    }

    protected function createComment($data){
        return Comment::create($data);
    }

    protected function deleteComment($id){
        return Comment::where('id', '=', $id)->delete();
    }
}