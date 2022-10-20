<div class="card pub_image">
                <div class="card-header">
                    @if($image->user->image)
                    <div class="container-avatar">
                        <img src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" class="avatar"/>
                    </div>
                    @endif
                    <div class="data-user">
                        <a href="{{ route('profile', ['id' => $image->user->id])}}">
                     {{$image->user->name.' '.$image->user->surname. ' |' }}</a>
                     <span class="nick-name">{{ '@'.$image->user->nick}}</span>
                    </div>
                </div>

                <div class="card-body">
                  
                    <div class="image-container">
                        <img src="{{route('image.file',['filename'=> $image->imagen_path]) }}"/>
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

                        <div class="comments">
                        <a href="{{ route('image.detail', ['id' => $image->id])}}" class="btn btn-outline-primary btn-sm btn-coments">
                            Comentarios ({{count($image->comments)}})
                        </a>
                    </div>
                   
                     <div class="description">
                        <span class="nick-name">{{ '@'.$image->user->nick}}</span>
                        <span class="nick-name">{{ ' | '.\FormatTime::LongTimeFilter($image->created_at)}}</span>
                        <p>{{$image->description}}</p>
                     </div>
                  
                </div>
            </div>