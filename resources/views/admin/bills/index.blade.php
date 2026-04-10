@extends('admin.layout')
@section('title', 'Contas a Pagar')
@section('content')

{{-- Alertas de vencimento --}}
@if($alerts->count())
<div class="alert alert-warning border-0 shadow-sm mb-4">
    <div class="fw-bold mb-2">⚠️ {{ $alerts->count() }} conta(s) vencida(s) ou vencendo em breve:</div>
    <ul class="mb-0">
        @foreach($alerts as $alert)
        @php
            $name    = $alert instanceof \App\Models\BillOccurrence ? $alert->bill->name : $alert->name;
            $due     = $alert instanceof \App\Models\BillOccurrence ? $alert->due_date : $alert->due_date;
            $overdue = $due->isPast();
        @endphp
        <li>
            <strong>{{ $name }}</strong> —
            @if($overdue)
                <span class="text-danger">Venceu em {{ $due->format('d/m/Y') }} ({{ $due->diffForHumans() }})</span>
            @else
                <span class="text-warning">Vence {{ $due->diffForHumans() }}</span>
            @endif
            — R$ {{ number_format($alert->amount, 2, ',', '.') }}
        </li>
        @endforeach
    </ul>
</div>
@endif

{{-- Cabeçalho --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.bills.index', ['month' => $month->copy()->subMonth()->format('Y-m')]) }}" class="btn btn-outline-secondary btn-sm">‹</a>
        <span class="fw-bold fs-5">{{ ucfirst($month->translatedFormat('F Y')) }}</span>
        <a href="{{ route('admin.bills.index', ['month' => $month->copy()->addMonth()->format('Y-m')]) }}" class="btn btn-outline-secondary btn-sm">›</a>
    </div>
    <a href="{{ route('admin.bills.create') }}" class="btn btn-danger">+ Nova Conta</a>
</div>

{{-- Resumo --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <div class="text-muted small">A Pagar</div>
            <div class="fw-bold fs-4 text-danger">R$ {{ number_format($totalPending, 2, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <div class="text-muted small">Pago</div>
            <div class="fw-bold fs-4 text-success">R$ {{ number_format($totalPaid, 2, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <div class="text-muted small">Total do Mês</div>
            <div class="fw-bold fs-4">R$ {{ number_format($totalPending + $totalPaid, 2, ',', '.') }}</div>
        </div>
    </div>
</div>

{{-- Contas Fixas --}}
<h6 class="fw-bold mb-2">🔁 Contas Fixas</h6>
<div class="card mb-4">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr><th>Nome</th><th>Vencimento</th><th>Valor</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($occurrences as $occ)
            <tr class="{{ $occ->status === 'overdue' ? 'table-danger' : ($occ->status === 'paid' ? 'table-success' : '') }}">
                <td>
                    {{ $occ->bill->name }}
                    @if($occ->bill->variable)
                        <span class="badge bg-info text-dark ms-1" title="Valor variável">variável</span>
                    @endif
                    @if($occ->bill->variable && $occ->status !== 'paid')
                        @php
                            $lastPaid = $occ->bill->occurrences()->where('status','paid')->orderByDesc('due_date')->first();
                        @endphp
                        @if($lastPaid)
                        <small class="text-muted d-block">Último mês: R$ {{ number_format($lastPaid->amount, 2, ',', '.') }}</small>
                        @endif
                    @endif
                </td>
                <td>{{ $occ->due_date->format('d/m/Y') }}</td>
                <td>R$ {{ number_format($occ->amount, 2, ',', '.') }}</td>
                <td>@include('admin.bills._status', ['status' => $occ->status])</td>
                <td class="text-end" style="white-space:nowrap">
                    @if($occ->status !== 'paid')
                    <button class="btn btn-sm btn-success"
                        onclick="openPayModal('occurrence', {{ $occ->id }}, '{{ addslashes($occ->bill->name) }}', {{ $occ->amount }}, {{ $occ->bill->variable ? 'true' : 'false' }})">
                        ✓ Pagar
                    </button>
                    @else
                    <small class="text-muted">{{ $occ->paid_at?->format('d/m/Y') }}</small>
                    @if($occ->receipt)
                    <a href="{{ Storage::url($occ->receipt) }}" target="_blank" class="btn btn-sm btn-outline-secondary ms-1">📎</a>
                    @endif
                    @endif
                    <a href="{{ route('admin.bills.edit', $occ->bill) }}" class="btn btn-sm btn-outline-secondary ms-1">Editar</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-3">Nenhuma conta fixa neste mês.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Contas Avulsas --}}
<h6 class="fw-bold mb-2">📄 Contas Avulsas</h6>
<div class="card">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr><th>Nome</th><th>Vencimento</th><th>Valor</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($singles as $bill)
            <tr class="{{ $bill->status === 'overdue' ? 'table-danger' : ($bill->status === 'paid' ? 'table-success' : '') }}">
                <td>
                    {{ $bill->name }}
                    @if($bill->description)
                    <small class="text-muted d-block">{{ $bill->description }}</small>
                    @endif
                </td>
                <td>{{ $bill->due_date->format('d/m/Y') }}</td>
                <td>R$ {{ number_format($bill->amount, 2, ',', '.') }}</td>
                <td>@include('admin.bills._status', ['status' => $bill->status])</td>
                <td class="text-end" style="white-space:nowrap">
                    @if($bill->status !== 'paid')
                    <button class="btn btn-sm btn-success"
                        onclick="openPayModal('single', {{ $bill->id }}, '{{ addslashes($bill->name) }}', {{ $bill->amount }}, false)">
                        ✓ Pagar
                    </button>
                    @else
                    <small class="text-muted">{{ $bill->paid_at?->format('d/m/Y') }}</small>
                    @endif
                    <a href="{{ route('admin.bills.edit', $bill) }}" class="btn btn-sm btn-outline-secondary ms-1">Editar</a>
                    <form method="POST" action="{{ route('admin.bills.destroy', $bill) }}" class="d-inline" onsubmit="return confirm('Remover?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">✕</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-3">Nenhuma conta avulsa neste mês.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal de Pagamento --}}
<div class="modal fade" id="payModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="payForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">💳 Registrar Pagamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">Conta: <strong id="payModalName"></strong></p>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Valor Pago (R$) *</label>
                        <input type="number" name="amount" id="payAmount" class="form-control form-control-lg" step="0.01" min="0" required>
                        <small class="text-muted" id="payAmountHint"></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comprovante <small class="text-muted">(JPG, PNG ou PDF — opcional)</small></label>
                        <input type="file" name="receipt" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">✓ Confirmar Pagamento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openPayModal(type, id, name, amount, variable) {
    const routes = {
        occurrence: '/admin/bills/occurrence/' + id + '/pay',
        single:     '/admin/bills/single/' + id + '/pay',
    };
    document.getElementById('payForm').action   = routes[type];
    document.getElementById('payModalName').textContent = name;
    document.getElementById('payAmount').value  = amount.toFixed(2);
    document.getElementById('payAmountHint').textContent = variable
        ? '⚠️ Valor variável — ajuste conforme a fatura recebida.'
        : 'Valor sugerido com base no cadastro. Altere se necessário.';
    new bootstrap.Modal(document.getElementById('payModal')).show();
}
</script>
@endsection
