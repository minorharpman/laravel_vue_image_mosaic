<?php

namespace App\Http\Controllers;

use App\FileUpload;
use App\Gallery;
use App\Mosaic;
use Auth;
use File;
use Illuminate\Http\Request;
use Validator;

//use Illuminate\Support\Facades\Input;

class ImageController extends Controller
{

    /*public function storetester()
    {

    return view('storetester');
    }*/

    public function storetesterUpload(Request $request)
    {

        $image = $request->image;
        var_dump($request->file('image'));
        if ($image) {
            $imageName = $image->getClientOriginalName();
            $imageName = "image_" . time() . '.' . request()->image->getClientOriginalExtension();
            $image->move('images', $imageName);
            $formInput['image'] = $imageName;
        }

    }

    public function registeredindex(Request $request)
    {

        $id = 0;
        $changeuserid = $request->get('changeuserid');
        if ($changeuserid != 0) {
            $id = $changeuserid;
        } else {
            $id = Auth::user()->id;
        }
        $gallery_id = $request->get('gallery_id');
        //echo "gallery_id: " . $gallery_id;
        $images_count = FileUpload::where('user_id', $id)->where('gallery_id', $gallery_id)->count();
        $images = FileUpload::where('user_id', $id)->where('gallery_id', $gallery_id)->orderBy('updated_at', 'desc')->paginate(20);
        //$images = FileUpload::orderBy('updated_at', 'desc')->get();

        //  $user_status = "registered";

        return response()->json([
            'images' => $images,
            'images_count' => $images_count,
            //  'user_status' => $user_status,
        ], 200);

    }

    public function index($gallery_id)
    {

        //$images = FileUpload::where('user_id', $id)->orderBy('updated_at', 'desc')->get();
        //$images = FileUpload::with('imageowner')->orderBy('updated_at', 'desc')->get();

        //$gallery_id = $request->get('gallery_id');
        //echo 'gallery_id:' . $gallery_id;

        //Ha nulla, nincs kiválasztva
        if ($gallery_id == 0) {
            $gallery = Gallery::orderBy('gallery_order', 'ASC')->orderBy('id', 'ASC')->first();
            $gallery_id = $gallery['id'];
        }

        $user_status = "guest";

        if (Auth::check()) {
            $id = Auth::user()->id;
            if ($id == 1) {
                $images = FileUpload::with('imageowner')->where('gallery_id', $gallery_id)->where('user_id', $id)->orderBy('updated_at', 'desc')->paginate(100);
            } else {
                // $images = FileUpload::with('imageowner')->orderBy('updated_at', 'desc')->get();
                $gallery_id = 0;
                $images = FileUpload::with('imageowner')->where('gallery_id', $gallery_id)->where('user_id', $id)->orderBy('updated_at', 'desc')->paginate(100);
            }

            $user_status = "registered";

            return response()->json([
                'images' => $images,
                'user_status' => $user_status,
                'user_id' => $id,
            ], 200);
        } else {
            $images = FileUpload::with('imageowner')->where('gallery_id', $gallery_id)->where('user_id', 1)->orderBy('updated_at', 'desc')->paginate(100);
            return response()->json([
                'images' => $images,
                'user_status' => $user_status,
                'user_id' => 'demo',
            ], 200);
        }

    }

    public function store(Request $request)
    {

        $id = Auth::user()->id;
        $images_count = FileUpload::where('user_id', $id)->where('gallery_id', $request->gallery_id)->count();
        //echo "count" . $images_count;

        if ($images_count >= 100) {

            return response()->json(['error' => "You can only upload 100 pictures."], 200);
        }

        $rules = [];

        //image size
        $image_size = env('IMAGE_SIZE');
        $rules['file'] = 'required|image|mimes:png,jpg,jpeg|max:' . $image_size;

        $messages = array(
            'required' => 'The :attribute field is required.',

        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            // Each failed field will have one or more messages.
            $message_string = "";
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                // Go through each message for this field.
                foreach ($messages as $message) {
                    $message_string .= $message;
                }
            }

            return response()->json(['error' => $message_string], 200);
        }

        if ($request->file('file')) {

            //resize: http://image.intervention.io/api/resize

            //original filename for the message
            $fileName = $request->file('file')->getClientOriginalName(); //Get Image Name
            $extension = $request->file('file')->getClientOriginalExtension(); //Get Image Extension
            $fileNameFull = $fileName . '.' . $extension;

            // $name = $fileNameFull;

            $name = "image_" . uniqid() . '_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            //echo 'filename: ' . $name;
            $image = \Image::make($request->file('file'));
            $image->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save(public_path('images/') . $name);

            $image_data = new FileUpload();
            $image_data->image_name = $name;
            $image_data->user_id = Auth::user()->id;
            $image_data->gallery_id = $request->gallery_id;
            $image_data->save();

            return response()->json(['info' => 'You have successfully uploaded an image (' . $fileNameFull . ')', 'id' => $image_data->id, 'error' => ''], 200);

        } else {
            return response()->json(['error' => "Upload error"], 200);
        }

    }

    public function storecanvas(Request $request)
    {
        // var_dump($request->input('file'));

        if ($request->input('file')) {

            /*  if (Auth::check()) {
            $user = Auth::user()->name;
            $name = crypt($user, 'sdasdsafsdfs') . "_" . uniqid() . "_mosaic.png";

            } else {
            $name = $request->input('order') . "_" . $request->input('current_my_uniqid') . "_" . "mosaic.png";
            }*/

            $name = $request->input('order') . "_" . $request->input('current_my_uniqid') . "_" . "mosaic.png";

            $image = \Image::make($request->input('file'));

            $image->save(public_path('mosaic/') . $name);

            $path = 'mosaic/' . $name;

            return response()->json(['path' => $path]
                , 200);

        }

    }

    public function collectimage(Request $request)
    {
        // echo "id:" . $request->input('id');

        if ($request->input('server_mosaic_parts_status') != "deleted") {
            $canvas = \Image::canvas($request->input('canvas_width'), $request->input('canvas_height'));

            $startImage_name = public_path('mosaic/') . "0_" . $request->input('id') . "_mosaic.png";

            //echo "startImage_name: " . $startImage_name;

            $image = \Image::make($startImage_name);

            $canvas->insert($image, 'top-left');

            for ($x = 1; $x <= 9; $x++) {
                $canvas->insert(public_path('mosaic/') . $x . "_" . $request->input('id') . "_mosaic.png", 'top-left', $x * $request->input('canvas_width_part'));
            }

            if (Auth::check()) {
                $user_part = Auth::user()->id . "_user_";
            } else {
                $user_part = "anon_user_";
            }

            $canvas->save(public_path('mosaic/') . $user_part . $request->input('id') . "_collected.png");

            //delete parts

            for ($x = 0; $x <= 9; $x++) {
                File::delete(public_path() . '/mosaic/' . $x . "_" . $request->input('id') . "_mosaic.png");
            }

//save in the gallery
            if (Auth::check()) {
                $image_data = new Mosaic();
                $image_data->image_name = $user_part . $request->input('id') . "_collected.png";
                $image_data->user_id = Auth::user()->id;
                $image_data->save();
            }

            //thumbnail 1 usernél
            if (Auth::check() && Auth::user()->id == 1) {

                $canvas->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $canvas->save(public_path('mosaic/') . "thumbnail_" . $user_part . $request->input('id') . "_collected.png");
            }

        }

        return response()->json([
            'canvas' => $user_part . $request->input('id') . "_collected.png",
            'server_mosaic_parts_status' => "deleted",

        ], 200);

    }

    public function delete(Request $request)
    {

        $id = $request->get('id');
        $image = FileUpload::find($id);

        File::delete(public_path() . '/images/' . $image->image_name);

        $image->delete();

        return response()->json([
            'image' => $image,
            'message' => 'image has been deleted!',
            'status' => 'ok',
        ], 200);

    }

    public function deleteall(Request $request)
    {

        $user_id = Auth::user()->id;
        $gallery_id = $request->get('gallery_id');

        //echo "user_id: " . $user_id;

        $images = FileUpload::where('user_id', $user_id)->where('gallery_id', $gallery_id)->get();

        //var_dump($images);

        foreach ($images as $image) {

            File::delete(public_path() . '/images/' . $image->image_name);

            $image->delete();

        }

        return response()->json([
            'image' => '',
            'message' => 'image has been deleted!',
            'status' => 'ok',
        ], 200);

    }

/*
admin function, delete not used records
 */

    public function deleteNotUsedRows($id)
    {

        $images = FileUpload::where('user_id', $id)->get();

        /*    foreach ($images as $image) {

        if (File::exists(public_path() . '/images/' . $image->image_name)) {
        echo $image->image_name . ' File is exists.<br>';
        } else {
        echo $image->image_name . ' File is not exists.<br>';
        }

        }*/

        return \View::make('admin/deletenotusedrows')->with(array('images' => $images));

    }
}
