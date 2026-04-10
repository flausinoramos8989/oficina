@extends('admin.layout')
@section('title', $banner->exists ? 'Editar Banner' : 'Novo Banner')
@section('content')
<div class="card p-4" style="max-width:600px">
    <form method="POST"
          action="{{ $banner->exists ? route('admin.banners.update', $banner) : route('admin.banners.store') }}"
          enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Subtítulo</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $banner->subtitle) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Imagem {{ $banner->exists ? '(deixe vazio para manter)' : '*' }}</label>
            @if($banner->exists)
            <div class="mb-2"><img src="{{ Storage::url($banner->image) }}" height="80" style="border-radius:8px"></div>
            @endif
            <input type="file" name="image" class="form-control" {{ $banner->exists ? '' : 'required' }} accept="image/*">
        </div>
        <div class="row g-3 mb-3">
            <div class="col">
                <label class="form-label">Ordem</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $banner->order ?? 0) }}">
            </div>
            <div class="col d-flex align-items-end">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ old('active', $banner->active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">Ativo</label>
                </div>
            </div>
        </div>
        @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <div class="d-flex gap-2">
            <button class="btn btn-danger">💾 Salvar</button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
