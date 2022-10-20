@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
         <div class="profile-user">
                @if($user->image)
                    <div class="container-avatar">
                        <img src="{{ route('user.avatar',['filename'=>$user->image]) }}" class="avatar"/>
                    </div>
                @endif


                <div class="user-info">
                    <h2>{{'@'.$user->nick}}</h2>
                    <h3>{{$user->name.' '. $user->surname}}</h3>
                    <span class="nick-name">{{ ' Se unió: '.\FormatTime::LongTimeFilter($user->created_at)}}</span>
                </div>
                  <div class="clearfix"></div> 
                <hr>
                
            </div>

         
        </div>

          <div class="clearfix"></div>
    </div> 

        <div class="row row-cols-1 row-cols-md-2 g-4">
            
                 @foreach($user->images as $image)
                     @include('includes.image')
                 @endforeach
           
        </div>
        
    
  
</div>
@endsection
