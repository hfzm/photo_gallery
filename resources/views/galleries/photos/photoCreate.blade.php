@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload New Photo</div>
                <div class="card-body">
                    <form action="{{route('photoStore')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="gallery_id" value="{{$gallery->id}}">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="title">Photo Title</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="cover">Photo</label>
                                <input type="file" name="photo" class="form-control">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="description">Photo Description</label>
                                <textarea name="description" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary" type="submit">Upload Photo</button>
                        <a href="{{route('galleryShow', $gallery->id)}}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
