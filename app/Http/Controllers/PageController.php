<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Vet;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'services' => Service::active()->where('is_featured', true)->orderBy('sort_order')->get(),
            'vets' => Vet::active()->orderBy('sort_order')->take(4)->get(),
            'gallery' => GalleryImage::active()->orderBy('sort_order')->take(6)->get(),
            'testimonials' => Testimonial::active()->orderBy('sort_order')->take(3)->get(),
            'posts' => Post::published()->latest('published_at')->take(3)->get(),
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // Demo: we simply acknowledge. (Hook up mail/notification in production.)
        return back()->with('status', 'Mesajınız bize ulaştı, en kısa sürede dönüş yapacağız. 🐾');
    }
}
