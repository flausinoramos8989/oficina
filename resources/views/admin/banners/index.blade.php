@extends('admin.layout')
@section('title', 'Banners')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.banners.create') }}" class="btn btn-danger">+ Novo Banner</a>
</div>
<div class="card">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr><th>Imagem</th><th>Título</th><th>Ordem</th><th>Ativo</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($banners as $banner)
            <tr>
                <td><img src="{{ Storage::url($banner->image) }}" height="50" style="border-radius:6px;object-fit:cover;width:80px"></td>
                <td>{{ $banner->title ?? '-' }}</td>
                <td>{{ $banner->order }}</td>
                <td>{{ $banner->active ? '✅' : '❌' }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" class="d-inline" onsubmit="return confirm('Remover?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Remover</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Nenhum banner cadastrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
