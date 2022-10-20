<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
   protected $table = 'comments';

   //Relación Many to One

   public function user(){
    return $this->belongsTo('App\User', 'user_id');
   }

   //Relación One to Many

   public function image(){
    return $this->belongsTo('App\Image', 'image_id');
   }


}
