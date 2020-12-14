<?php

namespace App\Http\Controllers;

use App\Mosaic;
use Auth;
use File;
use Illuminate\Http\Request;

class MosaicController extends Controller
{

    public function index()
    {

        $mosaics = Mosaic::with('imageowner')->where('user_id', 1)->orderBy('updated_at', 'desc')->get();

        //var_dump($mosaics);

        return view('mosaicview.index', compact(['mosaics']));

    }

    public function indexjson()
    {

        $mosaics = Mosaic::with('imageowner')->where('user_id', 1)->orderBy('updated_at', 'desc')->get();

        return response()->json([
            'mosaics' => $mosaics,
        ], 200);

    }

//csak a demo-nal latszik
    public function delete($id)
    {

        //echo 'id:' . $id;
        $mosaic = Mosaic::find($id);

        File::delete(public_path() . '/mosaic/' . $mosaic->image_name);
        File::delete(public_path() . '/mosaic/' . "thumbnail_" . $mosaic->image_name);

        $mosaic->delete();

        return response()->json([
            'image' => $mosaic,
            'message' => 'mosaic has been deleted!',
            'status' => 'ok',
        ], 200);

    }

    public function uploadindex()
    {
        return view('mosaicview.uploadindex', ['workuri' => env('WORK_URL')]);
    }

//mosaic upload
    public function store(Request $request)
    {

//csak az user 1 tölthet a gallériába
        if ($request->file('file') && Auth::user()->id == 1) {

            //original filename for the message
            $fileName = $request->file('file')->getClientOriginalName(); //Get Image Name
            $extension = $request->file('file')->getClientOriginalExtension(); //Get Image Extension
            $fileNameFull = $fileName . '.' . $extension;

            $name = $fileNameFull;

            $image = \Image::make($request->file('file'));

            $image->save(public_path('mosaic/') . $name);

            $image->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save(public_path('mosaic/') . "thumbnail_" . $name);

            //save in the table
            $image_data = new Mosaic();
            $image_data->image_name = $fileNameFull;
            $image_data->user_id = Auth::user()->id;
            $image_data->save();

            return response()->json(['info' => 'You have successfully uploaded an image (' . $fileNameFull . ')', 'id' => $image_data->id, 'error' => ''], 200);

        }

    }

}
