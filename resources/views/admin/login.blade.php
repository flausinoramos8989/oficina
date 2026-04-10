<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a1a2e; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { border: none; border-radius: 16px; width: 100%; max-width: 380px; }
    </style>
</head>
<body>
<div class="card shadow-lg p-4">
    <h4 class="text-center fw-bold mb-4">🔧 Admin Oficina</h4>
    @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-danger w-100">Entrar</button>
    </form>
</div>
</body>
</html>
