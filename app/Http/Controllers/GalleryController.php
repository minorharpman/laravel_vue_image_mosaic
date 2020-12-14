<?php

namespace App\Http\Controllers;

use App\Gallery;

class GalleryController extends Controller
{
    public function index()
    {

        $galleries = Gallery::orderBy('gallery_order', 'ASC')->orderBy('id', 'ASC')->get();

        return response()->json([
            'galleries' => $galleries,
        ], 200);

    }

}
