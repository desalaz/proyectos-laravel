<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
      //Restringimos el acceso con el middleware
      public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        //aqui me creo el objeto de esa clase y ordeno de manera descendente, tambien creo un objeto de usuario
        $user = \Auth::user();
        $likes = Like::where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->paginate(5);

        /*Ahora hay que pasarle a la vista el array con las imagenes que trajo el objeto */

        return view('like.index', [
            'likes'=> $likes
        ]);
 }

    public function like($image_id){

        //Recoger los datos del usuario identificado
        $user= \Auth::user();

        //Condición para ver si ya existe el like y no duplicarlo
        $isset_like = Like::where('user_id', $user->id)
                        ->where('image_id', $image_id)
                        ->count();
        // var_dump($isset_like);
        // die();

            if($isset_like == 0){
                $like = new Like();

              //Setteamos los valores al nuevo objeto
                $like->user_id = $user->id;
                $like->image_id = (int) $image_id; 
                  //Guadamos ese nuevo objeto en la base de datos
                 $like->save();
                //al ser este metodo consultado en Ajax, debemos retornar un Json, para poder manipularlo con JS
                return response()->json([
                    'like'=> $like
                ]);

                //   var_dump($like);

            }else{
                return response()->json([
                    'message'=> "Ya existe el like"
                ]);
                
            }

    }



    public function dislike($image_id){

        //Recogemos los datos del usuario registrado
        $user = \Auth::user();

        //Condición para saber si ya existe el like y no duplicarlo
        $like= Like::where('user_id', $user->id)
                    ->where('image_id', $image_id)
                    ->first();

        if($like){
            //Eliminamos el like de la base de datos
            $like->delete();

            return response()->json([
                'like' => $like,
                'message'=>'Has dado dislike correctamente'
            ]);
        }else{
             return response()->json([
                'message'=>'El like no existe'
             ]);


        }
    }


  
}

