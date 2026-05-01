<?php
namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Member;
use Illuminate\Http\Request;
use Inertia\Inertia;
class TransactionController extends Controller {
    public function index(Request $request) {
        $query = Transaction::with('member');
        if ($type = $request->input('type')) { $query->where('type', $type); }
        if ($search = $request->input('search')) { $query->where('description', 'like', "%$search%"); }
        $transactions = $query->orderBy('transaction_date', 'desc')->paginate(15)->withQueryString();
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
            'filters' => $request->only(['type', 'search']),
            'stats' => ['income' => $totalIncome, 'expense' => $totalExpense, 'balance' => $totalIncome - $totalExpense],
        ]);
    }
    public function create() {
        return Inertia::render('Transactions/Create', ['members' => Member::orderBy('first_name')->get(['id','first_name','last_name','member_code'])]);
    }
    public function store(Request $request) {
        $data = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'member_id' => 'nullable|exists:members,id',
            'payment_method' => 'required|in:cash,bank,check,transfer',
            'reference' => 'nullable|string|max:100',
        ]);
        $data['receipt_number'] = 'R-' . date('Ymd') . '-' . str_pad((Transaction::withoutGlobalScopes()->where('tenant_id', auth()->user()->tenant_id)->max('id') ?? 0) + 1, 5, '0', STR_PAD_LEFT);
        Transaction::create($data);
        return redirect()->route('transactions.index')->with('success', 'تم تسجيل العملية بنجاح');
    }
    public function show(Transaction $transaction) {
        $transaction->load('member');
        return Inertia::render('Transactions/Show', ['transaction' => $transaction]);
    }
    public function edit(Transaction $transaction) {
        return Inertia::render('Transactions/Edit', ['transaction' => $transaction, 'members' => Member::orderBy('first_name')->get(['id','first_name','last_name','member_code'])]);
    }
    public function update(Request $request, Transaction $transaction) {
        $data = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'member_id' => 'nullable|exists:members,id',
            'payment_method' => 'required|in:cash,bank,check,transfer',
            'reference' => 'nullable|string|max:100',
        ]);
        $transaction->update($data);
        return redirect()->route('transactions.index')->with('success', 'تم التحديث');
    }
    public function destroy(Transaction $transaction) {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'تم الحذف');
    }
}
