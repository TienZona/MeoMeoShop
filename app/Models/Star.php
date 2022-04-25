<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    protected $table = 'stars';
    protected $fillable = ['id_assessor', 'id_user', 'id_post', 'id_comment'];
    public $timestamps = false;

    public static function check($id_post, $id_user, $id_assessor, $id_comment){
        $data = Star::where('id_assessor',$id_assessor)
        ->where('id_user',$id_user)
        ->where('id_post',$id_post)
        ->where('id_comment',$id_comment)
        ->get();
        if(isset($data[0]['star'])) 
            return true;
        else 
            return false;
    }

    public static function unstar($id_post, $id_user, $id_assessor, $id_comment){
        Star::where('id_assessor',$id_assessor)
        ->where('id_user',$id_user)
        ->where('id_post',$id_post)
        ->where('id_comment',$id_comment)
        ->delete();
    }


    public static function deleteStar($id_post){
        Star::find('id_post', $id_post)->delete();
    }

    public static function getStar($id_post, $id_user, $id_assessor, $id_comment){
        return Star::where('id_assessor',$id_assessor)
        ->where('id_user',$id_user)
        ->where('id_post',$id_post)
        ->where('id_comment',$id_comment)
        ->get();
    }

    public static function numberStarOfUser($id_user){
        return Star::where('id_user',$id_user)->get()->count();
    }

    public static function getUserHasStar(){
        return Star::groupby('id_user')->distinct()->get();
    }

    public static function getStarOfComment($id_comment){
        return Star::where('id_comment',$id_comment)->get();
    }
}
