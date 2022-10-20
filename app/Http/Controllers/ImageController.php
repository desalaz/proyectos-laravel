<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iluminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Comment;
use App\Like;



class ImageController extends Controller
{
    //Restringimos el acceso con el middleware
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    //Como es un metodo que recibe información desde un formulario debe recibir el objeto Request
    public function save(Request $request){

        //Validamos los datos que llegan
        $validate = $this->validate($request, [
                'description'=> 'required',
                'imagen_path' => 'required|file|mimes:jpg,png'
        ]);

        //Recogemos los datos en nuevas variables
        $imagen_path=$request->file('imagen_path');
        $description=$request->input('description');

        //Creamos un objeto utilizando el modelo Image y asiganmos valores nuevos al objeto
        $image= new Image();
        $image->description = $description;
        //Necesitamos tambien el id del usuario identificado, ya que en la base de datos se necesita dicho campo
        $user = \Auth::user();
        $image->user_id= $user->id;

        //Subimos la foto
        if($imagen_path){
            //Me creo una variable temporal unica con le metodo time, y obtengo el nombre original con el metodo getClient...
            $image_path_name = time().$imagen_path->getClientOriginalName();
            //Con el metodo put subo el nombre de la imagen y el archivo como tal
            Storage::disk('images')->put($image_path_name, File::get($imagen_path));
           
            //Asigno a la variable imagen los valores ya seteados correctamente en el storage
            $image->imagen_path = $image_path_name;

            $image->created_at = $current_date = date('Y-m-d H:i:s');

            //Guardo la imagen
            $image->save();

            return redirect()->route('home')->with([
                    'message' => 'La imagen ha sido cargada correctamente'
            ]);
        }
    }

    public function getImage($filename){
        //al llamar al metodo este recibe un parametro que me llegará por get
        $file = Storage::disk('images')->get($filename);
        return Response($file, 200);
    }

    //recibe el id de la imagen que quiero sacar
    public function detail($id){
        //con el metodo find saco el objeto con ese id recibido
        $image = Image::find($id);

        return view('image.detail', [
            'image'=> $image
        ]);
    }


    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);
        $comments=Comment::where('image_id', $id)->get();
        $likes=Like::where('image_id', $id)->get();

        if($user && $image && $image->user->id == $user->id){
            //Eliminos los comentarios
            if($comments && count($comments)>=1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }

            //Elimino los likes
            if($likes && count($likes)>=1){
                foreach($likes as $like){
                    $like->delete();
                }
            }

            //Eliminar ficheros de la imagen
            Storage::disk('images')->delete($image->imagen_path);

            //Eliminar registros imagen
            $image->delete();

            $message= array('message'=>'La imagen ha sido borrada con exito');

        }else{
            $message= array('message'=>'La imagen no se ha borrado correctamente');
        }

        return redirect()->route('home')->with($message);
    }

    public function edit($id){
        $user= \Auth::user();
        $image= Image::find($id);

        if($user && $image && $image->user->id == $user->id){
            return view('image.edit', [
                'image'=> $image
            ]);

        }else{
            return redirect()->route('home');
        }

    }

    public function update(Request $request){
          //Validamos los datos que llegan
          $validate = $this->validate($request, [
            'description'=> 'required',
            'imagen_path' => 'required|file|mimes:jpg,png'
    ]);


        $image_id= $request->input('image_id');
        $imagen_path=$request->file('imagen_path');
        $description= $request->input('description');
        
    // var_dump($image_id);
    // var_dump($description);
    //     die();

    //Conserguir objeto image

    $image = Image::find($image_id);
    $image->description = $description;

      //Subimos la foto
      if($imagen_path){
        //Me creo una variable temporal unica con le metodo time, y obtengo el nombre original con el metodo getClient...
        $image_path_name = time().$imagen_path->getClientOriginalName();
        //Con el metodo put subo el nombre de la imagen y el archivo como tal
        Storage::disk('images')->put($image_path_name, File::get($imagen_path));
       
        //Asigno a la variable imagen los valores ya seteados correctamente en el storage
        $image->imagen_path = $image_path_name;

        $image->created_at = $current_date = date('Y-m-d H:i:s');

        //Guardo la imagen
        $image->update();

        return redirect()->route('image.detail', ['id' => $image_id])->with([
                'message' => 'La imagen Actualizada con exito'
        ]);
    }


    }
}
