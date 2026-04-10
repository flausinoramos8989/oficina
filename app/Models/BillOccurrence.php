<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillOccurrence extends Model
{
    protected $fillable = ['bill_id', 'due_date', 'amount', 'status', 'paid_at', 'receipt'];

    protected $casts = ['due_date' => 'date', 'paid_at' => 'date'];

    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }

    public function isDueSoon(): bool
    {
        return $this->status === 'pending'
            && $this->due_date->diffInDays(now(), false) >= -3
            && $this->due_date->isFuture();
    }

    public function isOverdue(): bool
    {
        return $this->status !== 'paid' && $this->due_date->isPast();
    }
}
