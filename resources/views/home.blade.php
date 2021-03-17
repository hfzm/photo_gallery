@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Galleries</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        @foreach($galleries as $gallery)
                            <div class="col-md-3">
                                <a href="{{route('galleryShow', $gallery->id)}}">
                                    <img src="{{asset('public/galleries/' . $gallery->cover)}}" alt="cover" width="150px">
                                    <p class="text-center">{{$gallery->title}}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Create New Gallery</div>
                <div class="card-body">
                    <a href="{{route('galleryCreate')}}" class="btn btn-success btn-block">Create New Gallery</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
