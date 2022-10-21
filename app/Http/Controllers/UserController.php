<?php

namespace App\Http\Controllers;
use Iluminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($search = null){
        if(!empty($search)){
           $users= User::where('nick','LIKE', '%'.$search.'%')
                        ->orWhere('name','LIKE','%'.$search.'%')
                        ->orWhere('surname','LIKE','%'.$search.'%') 
                        ->orderBy('id','desc')
                        ->paginate(5);
        }else{

        $users=User::orderBy('id', 'desc')->paginate(5);

        }

        return view('user.index', [
            'users'=> $users
        ]);
     
    }

   public function config(){
    return view('user.config');
   }


   public function update(Request $request){

    //Conseguir usuario identificado
    $user = \Auth::user();
    $id = $user->id;

    //Validar los datos del formulario
    $validate = $this->validate($request, [
        'name' => ['required', 'string', 'max:255'],
        'surname' => ['required', 'string', 'max:255'],
        'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id]
    ]);
   
    //Recoger datos del formulario
    $name = $request->input('name');
    $surname = $request->input('surname');
    $nick = $request->input('nick');
    $email = $request->input('email'); 
    //$password=$request->input('password');

    // var_dump($id);
    // var_dump($name);
    // var_dump($surname);
    // var_dump($email);
    // die();

    // Asignar nuevos valores al objeto del usuario
    $user->name = $name;
    $user->surname = $surname;
    $user->nick = $nick;
    $user->email = $email;

   //Subir la imagen del avatar del usario
   $imagen_path= $request->file('imagen_path');
   if($imagen_path){
    //Con time le creo un nombre temporal a ese objeto de imagen
    $imagen_path_name = time().$imagen_path->getClientOriginalName();
    //Luego utilizo el objeto de storage, y le indico en que disco lo quiero guardar
    //Utilizando el metodo put subo el nombre de la imagen, y el otro parametro es el nombre del archivo completo
    //utilizo el objeto File y con el meetodo get cargo esa archivo 
    Storage::disk('users')->put($imagen_path_name, File::get($imagen_path));

    $user->image= $imagen_path_name;
   }


    //Ejecutar consulta y cambios en la base de datos
    $user->update();
    return redirect()->route('config')
    ->with(['message'=>'Usuario actualizado correctamente']);
   }


   public function getImage($filename){
    $file = Storage::disk('users')->get($filename);
    return Response($file, 200);
   }

   
   public function profile($id){
    $user = User::find($id);
    return view('user.profile', [
        'user' => $user
    ]);
   }

  
}
