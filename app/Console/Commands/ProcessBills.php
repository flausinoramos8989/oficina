<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\BillOccurrence;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessBills extends Command
{
    protected $signature   = 'bills:process';
    protected $description = 'Gera ocorrências mensais das contas fixas e marca vencidas';

    public function handle(): void
    {
        $now = Carbon::now();

        // Gera ocorrências do mês atual para todas as contas fixas ativas
        Bill::where('type', 'fixed')->where('active', true)->each(function (Bill $bill) use ($now) {
            $bill->generateOccurrence($now);
        });

        // Marca como overdue todas as pendentes com vencimento passado
        BillOccurrence::where('status', 'pending')
            ->whereDate('due_date', '<', $now->toDateString())
            ->update(['status' => 'overdue']);

        // Faz o mesmo para contas avulsas
        Bill::where('type', 'single')
            ->where('status', 'pending')
            ->whereDate('due_date', '<', $now->toDateString())
            ->update(['status' => 'overdue']);

        $this->info('Contas processadas com sucesso.');
    }
}
