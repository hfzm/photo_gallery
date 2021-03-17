@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Photos <a href="{{route('home')}}" class="float-right"><i class="fa fa-arrow-left"></i> Go Back</a></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>{{$gallery->description}}</p>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($photos as $photo)
                            <div class="col-md-3">
                                <a href="{{route('photoShow', $photo->id)}}"><img src="{{asset('public/galleries/photos/' . $photo->photo)}}" alt="photo" width="100%"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">{{$gallery->title}}</div>
                <div class="card-body text-center">
                    <img src="{{asset('public/galleries/' . $gallery->cover)}}" alt="cover" width="100%">
                    <br><br>
                    <a href="{{route('photoCreate', $gallery->id)}}" class="btn btn-success btn-block">Upload Photo</a>
                    <br>
                    <a href="{{route('galleryEdit', $gallery->id)}}" class="btn btn-success btn-block">Edit Gallery</a>
                    <br>
                    <a @click="galleryDelete" class="btn btn-danger btn-block">Delete Gallery</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                gallery: {!! $gallery !!}
            },
            methods: {
                galleryDelete(gallery){
                    swal.fire({
                        title: 'Are you sure?',
                        text: "Gallery and the photos inside it will also be deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            axios.get('/gallery/user/galleries/delete/' + this.gallery.id).then(() => {
                                window.location.href = '/gallery/home';
                            });
                        }
                    })
                }
            }
        });
    </script>
@endsection
