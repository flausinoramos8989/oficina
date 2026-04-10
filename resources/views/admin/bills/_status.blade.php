@php
    $map = ['pending' => ['warning', 'A Pagar'], 'paid' => ['success', 'Pago'], 'overdue' => ['danger', 'Vencida']];
    [$color, $label] = $map[$status] ?? ['secondary', $status];
@endphp
<span class="badge bg-{{ $color }}">{{ $label }}</span>
