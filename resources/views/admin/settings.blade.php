@extends('admin.layout')
@section('title', 'Configurações')
@section('content')
<div class="card p-4">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        <h6 class="fw-bold mb-3">Logo</h6>
        <div class="row g-3 mb-4 align-items-center">
            <div class="col-auto">
                @if(!empty($settings['logo']))
                <img src="{{ Storage::url($settings['logo']) }}" height="64" style="border-radius:8px;object-fit:contain;background:#f0f0f0;padding:4px">
                @else
                <div style="width:80px;height:64px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.8rem">🔧</div>
                @endif
            </div>
            <div class="col">
                <input type="file" name="logo" class="form-control" accept="image/*">
                <small class="text-muted">PNG, JPG ou SVG. Máx. 2MB.</small>
            </div>
        </div>

        <h6 class="fw-bold mb-3">Textos do Site</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Nome do Site</label>
                <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Título do Hero</label>
                <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Subtítulo do Hero</label>
                <input type="text" name="hero_subtitle" class="form-control" value="{{ $settings['hero_subtitle'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Endereço</label>
                <input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}">
            </div>
            <div class="col-12">
                <label class="form-label">Texto Sobre Nós</label>
                <textarea name="about_text" class="form-control" rows="3">{{ $settings['about_text'] ?? '' }}</textarea>
            </div>
        </div>

        <h6 class="fw-bold mb-3">Contato & Redes Sociais</h6>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">WhatsApp (só números)</label>
                <input type="text" name="whatsapp" class="form-control" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="5511999999999">
            </div>
            <div class="col-md-4">
                <label class="form-label">Telefone</label>
                <input type="text" name="phone" class="form-control" value="{{ $settings['phone'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Facebook (URL)</label>
                <input type="url" name="facebook" class="form-control" value="{{ $settings['facebook'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Instagram (URL)</label>
                <input type="url" name="instagram" class="form-control" value="{{ $settings['instagram'] ?? '' }}">
            </div>
        </div>

        <button class="btn btn-danger mt-4">💾 Salvar</button>
    </form>
</div>
@endsection
