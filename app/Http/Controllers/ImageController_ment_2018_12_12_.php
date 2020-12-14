<?php

namespace App\Http\Controllers;

use App\FileUpload;
use Auth;
use File;
use Illuminate\Http\Request;
use Validator;

//use Illuminate\Support\Facades\Input;

class ImageController extends Controller
{

    public function storetester()
    {

        return view('storetester');
    }

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

    public function index()
    {

        //$images = FileUpload::where('user_id', $id)->orderBy('updated_at', 'desc')->get();
        $images = FileUpload::with('imageowner')->orderBy('updated_at', 'desc')->get();

        $user_status = "guest";

        if (Auth::check()) {
            $user_status = "registered";

            return response()->json([
                'images' => $images,
                'user_status' => $user_status,
            ], 200);
        } else {
            return response()->json([
                'images' => $images,
                'user_status' => $user_status,
            ], 200);
        }

    }

    public function store(Request $request)
    {

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
            $image = $request->file('file');

            $name = "image_" . time() . '.' . $request->file('file')->getClientOriginalExtension();
            \Image::make($request->file('file'))->save(public_path('images/') . $name);
        }

        $image = new FileUpload();
        $image->image_name = $name;
        $image->user_id = Auth::user()->id;

        $image->save();

        return response()->json(['info' => 'You have successfully uploaded an image', 'id' => $image->id, 'error' => ''], 200);

    }

    public function registeredindex()
    {

        $id = Auth::user()->id;
        $images = FileUpload::where('user_id', $id)->orderBy('updated_at', 'desc')->get();
        // $images = FileUpload::orderBy('updated_at', 'desc')->get();

        //  $user_status = "registered";

        return response()->json([
            'images' => $images,
            //  'user_status' => $user_status,
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
}
