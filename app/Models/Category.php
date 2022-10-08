<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $table = 'category';
    protected $fillable = ['name'];

    public $timestamps = false;


    public static function getAll(){
        return Category::all();
    }

    public static function getCategory($id){
        return Category::find($id);
    }

    public static function deleteCategory($id){
        return Category::find($id)->delete();
    }

    public static function updateCategory($id, $data){
        return Category::find($id)->update($data);
    }
}