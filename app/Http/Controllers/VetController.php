<?php

namespace App\Http\Controllers;

use App\Models\Vet;

class VetController extends Controller
{
    public function index()
    {
        return view('pages.vets', [
            'vets' => Vet::active()->orderBy('sort_order')->get(),
        ]);
    }
}
