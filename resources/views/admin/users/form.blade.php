@extends('admin.layout')
@section('title', $user->exists ? 'Editar Usuário' : 'Novo Usuário')
@section('content')
<div class="card p-4" style="max-width:500px">
    <form method="POST"
          action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nome *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Perfil *</label>
            <select name="role" class="form-select" required>
                <option value="funcionario" {{ old('role', $user->role) === 'funcionario' ? 'selected' : '' }}>Funcionário</option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Senha {{ $user->exists ? '(deixe vazio para manter)' : '*' }}</label>
            <input type="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }} minlength="6">
        </div>
        <div class="mb-3">
            <label class="form-label">Confirmar Senha</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <div class="d-flex gap-2">
            <button class="btn btn-danger">💾 Salvar</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
