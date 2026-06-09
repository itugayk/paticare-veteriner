<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('pages.services', [
            'services' => Service::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function show(Service $service)
    {
        abort_unless($service->is_active, 404);

        return view('pages.service-show', [
            'service' => $service,
            'others' => Service::active()->where('id', '!=', $service->id)->orderBy('sort_order')->take(4)->get(),
        ]);
    }
}
