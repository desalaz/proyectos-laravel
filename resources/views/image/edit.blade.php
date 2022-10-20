@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
<!-- Aqui verificamos si existe la sesión mensaje y mostramos el mensaje que colocamos en el update -->
         @include('includes.message')

            <div class="card">
                <div class="card-header">Actualizar imagen</div>

                <div class="card-body">
                    <form method="POST" action="{{route('image.update')}}" enctype="multipart/form-data">
                        @csrf
                     <input type="hidden" name="image_id" value="{{$image->id}}"/>
                     
                        <div class="form-group row">
                            <label for="imagen_path" class="col-md-4 col-form-label text-md-right">Imagen</label>

                            <div class="col-md-6">

                            @if($image->user->image)
                                <div class="container-avatar">
                                    <img src="{{ route('image.file',['filename'=> $image->imagen_path]) }}" class="avatar"/>
                                </div>
                            @endif
                                <input id="imagen_path" type="file" class="form-control @error('imagen_path') is-invalid @enderror" name="imagen_path" required autocomplete="imagen_path" autofocus>

                                @error('imagen_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Descripción</label>

                            <div class="col-md-6">
                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description"  required autocomplete="description" autofocus>{{$image->description}}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   Actualizar Imagen
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection