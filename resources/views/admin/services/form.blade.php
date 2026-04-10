@extends('admin.layout')
@section('title', $service->exists ? 'Editar Serviço' : 'Novo Serviço')
@section('content')
<div class="card p-4" style="max-width:600px">
    <form method="POST"
          action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Título *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $service->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $service->description) }}</textarea>
        </div>
        <div class="row g-3 mb-3">
            <div class="col">
                <label class="form-label">Ícone (emoji)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $service->icon) }}" placeholder="🔧">
            </div>
            <div class="col">
                <label class="form-label">Ordem</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $service->order ?? 0) }}">
            </div>
            <div class="col d-flex align-items-end">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ old('active', $service->active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">Ativo</label>
                </div>
            </div>
        </div>
        @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <div class="d-flex gap-2">
            <button class="btn btn-danger">💾 Salvar</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
