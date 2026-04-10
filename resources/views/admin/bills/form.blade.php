@extends('admin.layout')
@section('title', $bill->exists ? 'Editar Conta' : 'Nova Conta')
@section('content')
<div class="card p-4" style="max-width:560px">
    <form method="POST" action="{{ $bill->exists ? route('admin.bills.update', $bill) : route('admin.bills.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nome *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $bill->name) }}" required placeholder="Ex: Água, Aluguel, Fornecedor...">
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <input type="text" name="description" class="form-control" value="{{ old('description', $bill->description) }}">
        </div>

        @if(!$bill->exists)
        <div class="mb-3">
            <label class="form-label">Tipo *</label>
            <select name="type" id="type" class="form-select" required onchange="toggleType(this.value)">
                <option value="single" {{ old('type') === 'single' ? 'selected' : '' }}>Avulsa (data específica)</option>
                <option value="fixed"  {{ old('type') === 'fixed'  ? 'selected' : '' }}>Fixa (todo mês)</option>
            </select>
        </div>
        @else
        <input type="hidden" name="type" value="{{ $bill->type }}">
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" class="form-control" value="{{ $bill->type === 'fixed' ? 'Fixa (todo mês)' : 'Avulsa' }}" disabled>
        </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Valor base (R$) *</label>
            <input type="number" name="amount" class="form-control" value="{{ old('amount', $bill->amount) }}" step="0.01" min="0" required>
            <small class="text-muted" id="amount_hint"></small>
        </div>

        {{-- Opção variável: só para contas fixas --}}
        <div id="field_variable" class="mb-3" style="{{ old('type', $bill->type ?? 'single') === 'fixed' ? '' : 'display:none' }}">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="variable" value="1" id="variable"
                    {{ old('variable', $bill->variable ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="variable">
                    Valor variável <small class="text-muted">(ex: água, luz — muda todo mês)</small>
                </label>
            </div>
        </div>

        <div id="field_due_day" class="mb-3" style="{{ old('type', $bill->type ?? 'single') === 'fixed' ? '' : 'display:none' }}">
            <label class="form-label">Dia do Vencimento *</label>
            <input type="number" name="due_day" class="form-control" value="{{ old('due_day', $bill->due_day) }}" min="1" max="28" placeholder="Ex: 10">
            <small class="text-muted">Dia do mês em que vence (máx. 28)</small>
        </div>

        <div id="field_due_date" class="mb-3" style="{{ old('type', $bill->type ?? 'single') === 'single' ? '' : 'display:none' }}">
            <label class="form-label">Data de Vencimento *</label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $bill->due_date?->format('Y-m-d')) }}">
        </div>

        @if($bill->exists)
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ old('active', $bill->active) ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Ativa</label>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="d-flex gap-2">
            <button class="btn btn-danger">💾 Salvar</button>
            <a href="{{ route('admin.bills.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
function toggleType(val) {
    document.getElementById('field_due_day').style.display  = val === 'fixed'  ? '' : 'none';
    document.getElementById('field_due_date').style.display = val === 'single' ? '' : 'none';
    document.getElementById('field_variable').style.display = val === 'fixed'  ? '' : 'none';
    if (val === 'single') document.getElementById('variable').checked = false;
}
</script>
@endsection
