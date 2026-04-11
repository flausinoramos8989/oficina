<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillOccurrence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $month = Carbon::parse($request->get('month', now()->format('Y-m')))->locale('pt_BR');

        $occurrences = BillOccurrence::with('bill')
            ->whereYear('due_date', $month->year)
            ->whereMonth('due_date', $month->month)
            ->orderBy('due_date')
            ->get();

        $singles = Bill::where('type', 'single')
            ->whereYear('due_date', $month->year)
            ->whereMonth('due_date', $month->month)
            ->orderBy('due_date')
            ->get();

        $alerts = BillOccurrence::with('bill')
            ->where('status', '!=', 'paid')
            ->whereDate('due_date', '<=', now()->addDays(3))
            ->orderBy('due_date')
            ->get()
            ->merge(
                Bill::where('type', 'single')
                    ->where('status', '!=', 'paid')
                    ->whereDate('due_date', '<=', now()->addDays(3))
                    ->orderBy('due_date')
                    ->get()
            );

        $totalPending = $occurrences->whereIn('status', ['pending', 'overdue'])->sum('amount')
            + $singles->whereIn('status', ['pending', 'overdue'])->sum('amount');

        $totalPaid = $occurrences->where('status', 'paid')->sum('amount')
            + $singles->where('status', 'paid')->sum('amount');

        return view('admin.bills.index', compact('occurrences', 'singles', 'alerts', 'month', 'totalPending', 'totalPaid'));
    }

    public function create()
    {
        return view('admin.bills.form', ['bill' => new Bill]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:fixed,single',
            'amount'      => 'required|numeric|min:0',
            'variable'    => 'boolean',
            'due_day'     => 'required_if:type,fixed|nullable|integer|min:1|max:28',
            'due_date'    => 'required_if:type,single|nullable|date',
        ]);
        $data['active']   = true;
        $data['variable'] = $request->boolean('variable');

        $bill = Bill::create($data);

        if ($bill->isFixed()) {
            $bill->generateOccurrence(now());
        }

        return redirect()->route('admin.bills.index')->with('success', 'Conta cadastrada!');
    }

    public function edit(Bill $bill)
    {
        return view('admin.bills.form', compact('bill'));
    }

    public function update(Request $request, Bill $bill)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount'      => 'required|numeric|min:0',
            'variable'    => 'boolean',
            'due_day'     => 'nullable|integer|min:1|max:28',
            'due_date'    => 'nullable|date',
            'active'      => 'boolean',
        ]);
        $data['active']   = $request->boolean('active');
        $data['variable'] = $request->boolean('variable');
        $bill->update($data);

        return redirect()->route('admin.bills.index')->with('success', 'Conta atualizada!');
    }

    public function destroy(Bill $bill)
    {
        $bill->delete();
        return back()->with('success', 'Conta removida!');
    }

    // Pagar ocorrência de conta fixa (com modal: valor + comprovante)
    public function payOccurrence(Request $request, BillOccurrence $occurrence)
    {
        $data = $request->validate([
            'amount'  => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        if ($request->hasFile('receipt')) {
            if ($occurrence->receipt) {
                Storage::disk('public')->delete($occurrence->receipt);
            }
            $data['receipt'] = $request->file('receipt')->store('receipts', 'public');
        }

        $occurrence->update(array_merge($data, ['status' => 'paid', 'paid_at' => now()]));

        return back()->with('success', 'Conta marcada como paga!');
    }

    // Pagar conta avulsa (com modal: valor + comprovante)
    public function paySingle(Request $request, Bill $bill)
    {
        $request->validate([
            'amount'  => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        $bill->update([
            'amount'  => $request->amount,
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        // Guarda comprovante numa ocorrência avulsa para manter histórico
        if ($receiptPath) {
            BillOccurrence::updateOrCreate(
                ['bill_id' => $bill->id, 'due_date' => $bill->due_date],
                ['amount' => $request->amount, 'status' => 'paid', 'paid_at' => now(), 'receipt' => $receiptPath]
            );
        }

        return back()->with('success', 'Conta marcada como paga!');
    }
}
