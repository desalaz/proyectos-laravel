@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.message')
          
            <div class="card pub_image pub_image_detail">
                <div class="card-header">
                    @if($image->user->image)
                    <div class="container-avatar">
                        <img src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" class="avatar"/>
                    </div>
                    @endif
                    <div class="data-user">
                     {{$image->user->name.' '.$image->user->surname. ' |' }}
                     <span class="nick-name">{{ '@'.$image->user->nick}}</span>
                    </div>
                </div>

                <div class="card-body">
                  
                    <div class="image-container image-detail">
                        <img src="{{route('image.file',['filename'=> $image->imagen_path]) }}"/>
                    </div>

                     <div class="description">
                        <span class="nick-name">{{ '@'.$image->user->nick}}</span>
                        <span class="nick-name">{{ ' | '.\FormatTime::LongTimeFilter($image->created_at)}}</span>
                        <p>{{$image->description}}</p>
                     </div>

                     <div class="likes">
                       
                        <!-- Comprobamos si el usuario le dio like a la imagen -->

                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                            @if($like->user->id == Auth::user()->id)
                            <?php $user_like = true; ?> 
                            @endif
                        @endforeach

                        @if($user_like)
                            <img src="{{ asset('img/hearts-red.png')}}" data-id="{{$image->id}}" class="btn-dislike"/>
                        @else
                        <img src="{{ asset('img/hearts-white.png')}}" data-id="{{$image->id}}"  class="btn-like"/>
                        @endif
                        <span class="number-likes">{{count($image->likes)}}</span>

                     </div>
                    @if(Auth::user()->id == $image->user->id)
                    <div class="actions">
                            <a class="btn btn-warning btn-sm" href="{{route('image.edit', ['id' => $image->id])}}">Actualizar</a>
                            <!-- <a class="btn btn-danger btn-sm" href="{{route('image.delete', ['id' => $image->id])}}">Borrar</a> -->

                                                    <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal">
                            Borrar
                            </button>

                            <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Eliminar Publicaci??n</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Si eliminas esta publicaci??n no podr??s recuperarla luego, ??Est??s seguro que deseas eliminarla?
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Volver</button>
                                    <a class="btn btn-danger btn-sm" href="{{route('image.delete', ['id' => $image->id])}}">Eliminar Publicaci??n</a>
                                </div>

                                </div>
                            </div>
                         </div>

                    </div>
                    @endif
                     <div class="clearfix"></div>
                        <div class="comments">
                      
                           <h3> Comentarios ({{count($image->comments)}})</h3>
                           <hr>

                           <form method= "POST" action="{{route('comment.save')}}">
                                 @csrf

                             <input type="hidden" name="image_id" value="{{$image->id}}"/>
                              <p>
                                 <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" cols="30" rows="10"></textarea>
                                  @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                             </p>
                            
                             <button class="btn btn-primary btn-sm" type="submit">Enviar</button>
                           </form>

                           <hr>

                           @foreach($image->comments as $comment)
                            <div class="comment">
                            <span class="nick-name">{{ '@'.$comment->user->nick}}</span>
                             <span class="nick-name">{{ ' | '.\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                             <p>{{$comment->content}}<br>

                             @if(Auth::check() && ($comment->user_id == Auth::user()->id) || ($comment->image->user_id == Auth::user()->id) )
                             <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn btn-sm btn-danger">
                                Eliminar
                             </a>
                            @endif
                            </p>
                            </div>

                           @endforeach
                       
                    </div>

                  
                </div>
            </div>
            
        </div>
    

    </div>
</div>
@endsection
