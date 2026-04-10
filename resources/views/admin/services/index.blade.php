@extends('admin.layout')
@section('title', 'Serviços')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.services.create') }}" class="btn btn-danger">+ Novo Serviço</a>
</div>
<div class="card">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr><th>Ícone</th><th>Título</th><th>Ordem</th><th>Ativo</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td style="font-size:1.5rem">{{ $service->icon }}</td>
                <td>{{ $service->title }}</td>
                <td>{{ $service->order }}</td>
                <td>{{ $service->active ? '✅' : '❌' }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="d-inline" onsubmit="return confirm('Remover?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Remover</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Nenhum serviço cadastrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
