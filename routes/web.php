<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
  
/*Probando del ORM

use App\Image;
    $images= Image::all();
    foreach($images as $image){
       // var_dump($image);
      echo $image->imagen_path."<br>";
      echo $image->description."<br>";
      // usando un objeto de otra clase (users)
      echo $image->user->name.' '.$image->user->surname;

      //tambien puedo usar los comentarios
      if(sizeof($image->comments) >=1){ 
        echo '<h4><strong>Comentarios:</strong></h4>';
        foreach($image->comments as $comment){
            echo $comment->user->name.' '.$comment->user->surname.': ';
            echo $comment->content.'<br>';
          }
        }
        //con esto contamos los likes
        $totalLikes=count($image->likes);

          if($totalLikes>=1){
          echo '<br>LIKES:'.$totalLikes;
          }
      echo "<hr>";
    }
        // die();
   */

//GENERAL ROUTES
Route::get('/', function () {    
    return view('welcome'); 
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//USER

Route::get('/configuracion', 'UserController@config')->name('config');

Route::post('/user/update', 'UserController@update')->name('user.update');

Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');

Route::get('/perfil/{id}','UserController@profile')->name('profile');

Route::get('gente/{search?}', 'UserController@index')->name('user.index');


//IMAGE

Route::get('/subir-imagen', 'ImageController@create')->name('image.create');

Route::post('/image/save', 'ImageController@save')->name('image.save');

Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');

Route::get('/imagen/{id}', 'ImageController@detail')->name('image.detail');

Route::get('/image/delete/{id}','ImageController@delete')->name('image.delete');

Route::get('/imagen/editar/{id}', 'ImageController@edit')->name('image.edit');

Route::post('/image/update', 'ImageController@update')->name('image.update');


//COMMENT

Route::post('/comment/save', 'CommentController@save')->name('comment.save');

Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

//LIKE

Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');

Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');

Route::get('/likes', 'LikeController@index')->name('likes');













