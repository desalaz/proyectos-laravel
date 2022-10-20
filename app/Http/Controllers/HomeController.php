<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image; 
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //aqui me creo el objeto de esa clase y ordeno de manera descendente
        $images = Image::orderBy('id', 'desc')->paginate(5);

        /*Ahora hay que pasarle a la vista el array con las imagenes que trajo el objeto */

        return view('home', [
            'images'=> $images
        ]);
    }

  




}
