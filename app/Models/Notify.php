<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model {
    protected $table = 'notify';
    protected $fillable = ['id_user', 'title', 'content', 'image', 'watched'];

    protected function getNotifyPagination($id, $number){
        return $this::where('watched', '=', 0)
        // ->whereBetween('price', $domain)
        ->orderBy('id', 'desc')
        ->where('id_user', '=', $id)
        ->skip(0)
        ->take($number)
        ->get();;
    }

    protected function watched($id){
        return $this::where('id', '=', $id)
        ->update(['wacthed' => 1]);
    }

    protected function addNotify($data){
        return $this::create($data);
    }

    protected function createNotify($data){
        return $this::create($data);
    }
}