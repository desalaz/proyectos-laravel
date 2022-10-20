<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    //Relación One to Many 
    public function comments(){
      //aplicamos el orderBy para que los comentarios se listen de mas nuevo a mas antiguo
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

      //Relación One to Many 
      public function likes(){
        return $this->hasMany('App\Like');
    }

     //Relación Many to One 
     public function user(){
      return $this->belongsTo('App\User', 'user_id');
    }

}

