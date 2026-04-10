@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
@php
    $alertCount = \App\Models\BillOccurrence::where('status', '!=', 'paid')->whereDate('due_date', '<=', now()->addDays(3))->count()
        + \App\Models\Bill::where('type', 'single')->where('status', '!=', 'paid')->whereDate('due_date', '<=', now()->addDays(3))->count();
@endphp
@if($alertCount)
<div class="alert alert-warning d-flex justify-content-between align-items-center">
    <span>⚠️ <strong>{{ $alertCount }} conta(s)</strong> vencida(s) ou vencendo nos próximos 3 dias!</span>
    <a href="{{ route('admin.bills.index') }}" class="btn btn-sm btn-warning">Ver Contas</a>
</div>
@endif
<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <div style="font-size:2.5rem">🖼️</div>
            <h5 class="mt-2">Banners</h5>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-outline-danger mt-2">Gerenciar</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <div style="font-size:2.5rem">🔧</div>
            <h5 class="mt-2">Serviços</h5>
            <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-danger mt-2">Gerenciar</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <div style="font-size:2.5rem">⚙️</div>
            <h5 class="mt-2">Configurações</h5>
            <a href="{{ route('admin.settings.edit') }}" class="btn btn-sm btn-outline-danger mt-2">Editar</a>
        </div>
    </div>
</div>
<div class="mt-4">
    <a href="{{ route('site.index') }}" target="_blank" class="btn btn-outline-secondary">👁️ Ver site</a>
</div>
@endsection
