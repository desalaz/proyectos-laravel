@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cols-1 justify-content-center">
        <div class="col-md-8">
           <h1>Nuestra Comunidad</h1>
       

           <form class="form-inline" method="GET" action="{{route('user.index')}}" id="buscador">
         <input class="form-control mr-sm-2" type="search" placeholder="Buscar" id= "search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>


        <hr>


       
            @foreach($users as $user)
             <div class="row row-cols-1">
            <div class="profile-user col-md-8">
                @if($user->image)
                    <div class="container-avatar">
                        <img src="{{ route('user.avatar',['filename'=>$user->image]) }}" class="avatar"/>
                    </div>
                @endif
           
                <div class="user-info">
                    <h3>{{'@'.$user->nick}}</h3>
                    <h4>{{$user->name.' '. $user->surname}}</h4>
                    <span class="nick-name">{{ ' Se unió: '.\FormatTime::LongTimeFilter($user->created_at)}}</span><br>
                   <br><a class="btn btn-sm btn-outline-primary" href="{{route('profile', ['id'=> $user->id])}}">Ver perfil</a>
                </div>
                  <div class="clearfix"></div> 
                <hr>
                
             </div>
        
            </div>
        
            @endforeach

            <!-- Paginación de la aplicacion -->
                <div class="clearfix"></div>
               
                    {{$users->links()}}
            
        </div>
        <div class="clearfix"></div> 
</div>
    </div>
    
</div>

@endsection
