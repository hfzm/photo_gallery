<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Photo;
use Auth;
Use Alert;
use DB;

class GalleryController extends Controller
{
    public function galleryCreate(){
        return view('galleries.galleryCreate');
    }

    public function galleryStore(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'cover' => 'required',
            'description' => 'required'
        ]);

        $gallery = new Gallery;

        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->user_id = Auth::user()->id;

        $cover = $request->file('cover');
        $cover_ext = $cover->getClientOriginalExtension();
        $cover_name = rand(123456, 999999) . '.' . $cover_ext;
        $cover_path = public_path('galleries/');
        $cover->move($cover_path, $cover_name);

        $gallery->cover = $cover_name;

        $gallery->save();

        toast('Gallery created successfully!','success')->timerProgressBar();
        return redirect()->route('home');

    }

    public function galleryShow($id){
        $gallery = Gallery::find($id);
        $photos = Photo::where('gallery_id', $gallery->id)->get();
        return view('galleries.galleryShow', compact('gallery', 'photos'));
    }

    public function galleryEdit($id){
        $gallery = Gallery::find($id);
        return view('galleries.galleryEdit', compact('gallery'));
    }

    public function galleryUpdate(Request $request, $id){
        $gallery = Gallery::find($id);

        $gallery->title = $request->title;
        $gallery->description = $request->description;

        $gallery_cover = $gallery->cover;

        if($request->hasFile('cover')){
            unlink(public_path('galleries/' . $gallery_cover));

            $cover = $request->file('cover');
            $cover_ext = $cover->getClientOriginalExtension();
            $cover_name = rand(123456, 999999) . '.' . $cover_ext;
            $cover_path = public_path('galleries/');
            $cover->move($cover_path, $cover_name);
            $gallery->cover = $cover_name;
        } else{
            $gallery->cover = $request->old_cover;
        }

        $gallery->save();
        toast('Gallery updated successfully!','success')->timerProgressBar();
        return redirect()->route('galleryShow', $id);
    }

    public function galleryDelete($id){
        $photos = Photo::where('gallery_id', $id)->get();
        foreach($photos as $photo){
            $photo_name = $photo->photo;
            unlink(public_path('galleries/photos/'. $photo_name));
        }

        DB::table('photos')->where('gallery_id', $id)->delete();

        $gallery = Gallery::find($id);
        $gallery_cover = $gallery->cover;
        unlink(public_path('galleries/') . $gallery_cover);
        $gallery->delete();
        toast('Gallery deleted successfully!','success')->timerProgressBar();
    }

    // photo methods
    public function photoCreate($id){
        $gallery = Gallery::find($id);
        return view('galleries/photos/photoCreate', compact('gallery'));
    }

    public function photoStore(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'photo' => 'required',
            'description' => 'required'
        ]);

        $photo = new Photo;

        $gallery_id = $request->gallery_id;

        $photo->gallery_id = $gallery_id;
        $photo->title = $request->title;
        $photo->description = $request->description;

        $photo_file = $request->file('photo');
        $photo_file_ext = $photo_file->getClientOriginalExtension();
        $photo_file_name = rand(123456, 999999) . '.' . $photo_file_ext;
        $photo_file_path = public_path('galleries/photos/');
        $photo_file->move($photo_file_path, $photo_file_name);

        $photo->photo = $photo_file_name;

        $photo->save();
        toast('Photo uploaded successfully!','success')->timerProgressBar();
        return redirect()->route('galleryShow', $gallery_id);
    }

    public function photoShow($id){
        $photo = Photo::find($id);
        return view('galleries/photos/photoShow', compact('photo'));
    }

    public function photoEdit($id){
        $photo = Photo::find($id);
        return view('galleries/photos/photoEdit', compact('photo'));
    }

    public function photoUpdate(Request $request, $id){
        $photo = Photo::find($id);

        $photo->title = $request->title;
        $photo->description = $request->description;

        $photo_name = $photo->photo;

        if($request->hasFile('photo')){
            unlink(public_path('galleries/photos/' . $photo_name));

            $new_photo = $request->file('photo');
            $new_photo_ext = $new_photo->getClientOriginalExtension();
            $new_photo_name = rand(123456, 999999) . '.' . $new_photo_ext;
            $new_photo_path = public_path('galleries/photos/');
            $new_photo->move($new_photo_path, $new_photo_name);

            $photo->photo = $new_photo_name;
        }else{
            $photo->photo = $request->old_photo;
        }

        $photo->save();
        toast('Photo updated successfully!','success')->timerProgressBar();
        return redirect()->route('photoShow', $id);
    }

    public function photoDelete($id){
        $photo = Photo::find($id);
        $photo_name = $photo->photo;
        $gallery_id = $photo->gallery_id;
        unlink(public_path('galleries/photos/' . $photo_name));
        $photo->delete();
        toast('Photo deleted successfully!','success')->timerProgressBar();
    }
}
