@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update Photo</div>
                <div class="card-body">
                    <form action="{{route('photoUpdate', $photo->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="title">Photo Title</label>
                                <input type="text" name="title" value="{{$photo->title}}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="cover">Photo</label>
                                <input type="file" name="photo" class="form-control">
                                <input type="hidden" name="old_photo" value="{{$photo->photo}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="description">Photo Description</label>
                                <textarea name="description" rows="3" class="form-control">{{$photo->description}}</textarea>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                        <a href="{{route('photoShow', $photo->id)}}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
