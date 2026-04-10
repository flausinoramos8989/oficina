@extends('admin.layout')
@section('title', 'Usuários')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.users.create') }}" class="btn btn-danger">+ Novo Usuário</a>
</div>
<div class="card">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr><th>Nome</th><th>E-mail</th><th>Perfil</th><th></th></tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }} @if($user->id === auth()->id()) <span class="badge bg-secondary">você</span> @endif</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                        {{ $user->role === 'admin' ? 'Admin' : 'Funcionário' }}
                    </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Remover usuário?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Remover</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
