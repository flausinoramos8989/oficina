<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }

    // Settings
    public function settingsEdit()
    {
        return view('admin.settings', ['settings' => Setting::pluck('value', 'key')]);
    }

    public function settingsUpdate(Request $request)
    {
        $request->validate(['logo' => 'nullable|image|max:2048']);

        if ($request->hasFile('logo')) {
            $old = Setting::get('logo');
            if ($old) Storage::disk('public')->delete($old);
            Setting::set('logo', $request->file('logo')->store('logo', 'public'));
        }

        foreach ($request->except(['_token', '_method', 'logo']) as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        return back()->with('success', 'Configurações salvas!');
    }

    // Banners
    public function bannersIndex()
    {
        return view('admin.banners.index', ['banners' => Banner::orderBy('order')->get()]);
    }

    public function bannersCreate()
    {
        return view('admin.banners.form', ['banner' => new Banner]);
    }

    public function bannersStore(Request $request)
    {
        $data = $request->validate([
            'title'    => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image'    => 'required|image|max:2048',
            'active'   => 'boolean',
            'order'    => 'integer',
        ]);
        $data['image'] = $request->file('image')->store('banners', 'public');
        $data['active'] = $request->boolean('active');
        Banner::create($data);
        return redirect()->route('admin.banners.index')->with('success', 'Banner criado!');
    }

    public function bannersEdit(Banner $banner)
    {
        return view('admin.banners.form', compact('banner'));
    }

    public function bannersUpdate(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title'    => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image'    => 'nullable|image|max:2048',
            'active'   => 'boolean',
            'order'    => 'integer',
        ]);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $data['image'] = $request->file('image')->store('banners', 'public');
        }
        $data['active'] = $request->boolean('active');
        $banner->update($data);
        return redirect()->route('admin.banners.index')->with('success', 'Banner atualizado!');
    }

    public function bannersDestroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->image);
        $banner->delete();
        return back()->with('success', 'Banner removido!');
    }

    // Services
    public function servicesIndex()
    {
        return view('admin.services.index', ['services' => Service::orderBy('order')->get()]);
    }

    public function servicesCreate()
    {
        return view('admin.services.form', ['service' => new Service]);
    }

    public function servicesStore(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:10',
            'active'      => 'boolean',
            'order'       => 'integer',
        ]);
        $data['active'] = $request->boolean('active');
        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Serviço criado!');
    }

    public function servicesEdit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function servicesUpdate(Request $request, Service $service)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:10',
            'active'      => 'boolean',
            'order'       => 'integer',
        ]);
        $data['active'] = $request->boolean('active');
        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'Serviço atualizado!');
    }

    public function servicesDestroy(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Serviço removido!');
    }
}
