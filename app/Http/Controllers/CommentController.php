<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
     //Restringimos el acceso con el middleware
     public function __construct(){
        $this->middleware('auth');
    }

    public function save(Request $request){
        //Validacion de los campos
        $validate = $this->validate($request, [
                'image_id' => 'integer|required',
                'content' => 'string|required'
        ]);

        //Recoger los datos del formulario
        $user = \Auth::user();
        $image_id = $request->input('image_id');  
        $content = $request->input('content');

        // var_dump($content);
        // die();

        //Ahora creamos una instacia de commet para guardar los datos
        $comment = new Comment();
        //Asigno los valore a mi nuevo objeto a guardar
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        // $comment->created_at = $current_date = date('Y-m-d H:i:s');

        //guardar en la base de datos
        $comment->save();

        //Redireccion con mensaje (session flat)
        return redirect()->route('image.detail', ['id'=> $image_id])
        ->with([
            'message' => 'Tu comentario ha sido publicado correctamente'
        ]);


    }

    public function delete($id){
        //Conserguir datos del usuario identificado
        $user = \Auth::user();

        //Conseguir objeto del comentario
        $comment = Comment::find($id);

        if($user && ($comment->user_id == $user->id) || ($comment->image->user_id == $user->id) ){
            $comment->delete();

            return redirect()->route('image.detail', ['id'=> $comment->image->id])
            ->with([
                'message' => 'Tu comentario ha sido borrado correctamente'
            ]);

        }else{

            return redirect()->route('image.detail', ['id'=> $comment->image->id])
            ->with([
                'message' => 'Tu comentario No ha sido borrado'
            ]);

        }

    }
}
