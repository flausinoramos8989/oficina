<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Bill extends Model
{
    protected $fillable = ['name', 'description', 'type', 'amount', 'due_day', 'due_date', 'status', 'paid_at', 'active', 'variable'];

    protected $casts = ['due_date' => 'date', 'paid_at' => 'date', 'variable' => 'boolean'];

    public function occurrences(): HasMany
    {
        return $this->hasMany(BillOccurrence::class);
    }

    public function isFixed(): bool
    {
        return $this->type === 'fixed';
    }

    // Retorna o valor da última ocorrência paga (para variáveis) ou o valor base
    public function suggestedAmount(): float
    {
        if ($this->variable) {
            $last = $this->occurrences()
                ->where('status', 'paid')
                ->orderByDesc('due_date')
                ->value('amount');
            return $last ?? $this->amount;
        }
        return $this->amount;
    }

    public function generateOccurrence(Carbon $month): BillOccurrence
    {
        $dueDate = $month->copy()->day($this->due_day);

        return BillOccurrence::firstOrCreate(
            ['bill_id' => $this->id, 'due_date' => $dueDate->toDateString()],
            ['amount' => $this->suggestedAmount(), 'status' => 'pending']
        );
    }
}
