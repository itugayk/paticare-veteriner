<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;

class GalleryController extends Controller
{
    public function index()
    {
        return view('pages.gallery', [
            'images' => GalleryImage::active()->orderBy('sort_order')->get(),
        ]);
    }
}
