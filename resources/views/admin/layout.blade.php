<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Painel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .sidebar { width: 240px; min-height: 100vh; background: #1a1a2e; position: fixed; top: 0; left: 0; }
        .sidebar .brand { color: #fff; font-weight: 800; font-size: 1.2rem; padding: 1.2rem 1rem; border-bottom: 1px solid #ffffff22; display: flex; flex-direction: column; align-items: center; gap: 8px; text-align: center; }
        .sidebar .brand img { max-width: 120px; max-height: 48px; object-fit: contain; }
        .sidebar .brand span { font-size: .95rem; font-weight: 700; color: #fff; line-height: 1.2; }
        .sidebar .nav-link { color: #ccc; padding: .6rem 1rem; border-radius: 8px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #e63946; color: #fff; }
        .sidebar .nav-section { color: #ffffff55; font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; padding: .8rem 1.2rem .3rem; }
        .main { margin-left: 240px; padding: 2rem; }
        .topbar { background: #fff; border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,.05); }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="brand">
        @php
            $logo     = \App\Models\Setting::get('logo');
            $siteName = \App\Models\Setting::get('site_name', 'Oficina');
        @endphp
        @if($logo)
        <img src="{{ Storage::url($logo) }}" alt="{{ $siteName }}">
        @endif
        <span>{{ $siteName }}</span>
    </div>
    <nav class="nav flex-column mt-3">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>

        <div class="nav-section">Site</div>
        <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">⚙️ Configurações</a>
        <a class="nav-link {{ request()->routeIs('admin.banners*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">🖼️ Banners</a>
        <a class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">🔧 Serviços</a>

        <div class="nav-section">Sistema</div>
        <a class="nav-link {{ request()->routeIs('admin.bills*') ? 'active' : '' }}" href="{{ route('admin.bills.index') }}">💰 Contas a Pagar</a>
        @if(auth()->user()->isAdmin())
        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">👥 Usuários</a>
        @endif
    </nav>
</div>
<div class="main">
    <div class="topbar">
        <h5 class="mb-0 fw-bold">@yield('title', 'Dashboard')</h5>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">
                {{ auth()->user()->name }}
                <span class="badge {{ auth()->user()->isAdmin() ? 'bg-danger' : 'bg-primary' }} ms-1">
                    {{ auth()->user()->isAdmin() ? 'Admin' : 'Funcionário' }}
                </span>
            </span>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-danger">Sair</button>
            </form>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
