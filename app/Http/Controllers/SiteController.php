<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Service;
use App\Models\Setting;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.index', [
            'banners'  => Banner::where('active', true)->orderBy('order')->get(),
            'services' => Service::where('active', true)->orderBy('order')->get(),
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }
}
