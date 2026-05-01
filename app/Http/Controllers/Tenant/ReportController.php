<?php
namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Meeting;
use App\Models\Project;
use App\Models\MemberSubscription;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ReportController extends Controller {
    public function index() {
        $stats = [
            'members' => ['total' => Member::count(), 'active' => Member::where('status','active')->count(), 'inactive' => Member::where('status','inactive')->count()],
            'finance' => ['income' => Transaction::where('type','income')->sum('amount'), 'expense' => Transaction::where('type','expense')->sum('amount')],
            'meetings' => ['total' => Meeting::count(), 'completed' => Meeting::where('status','completed')->count()],
            'projects' => ['total' => Project::count(), 'active' => Project::where('status','active')->count(), 'completed' => Project::where('status','completed')->count()],
            'subscriptions' => ['active' => MemberSubscription::where('status','active')->count(), 'expired' => MemberSubscription::where('status','expired')->count()],
        ];
        $monthlyIncome = Transaction::where('type','income')->whereYear('transaction_date', date('Y'))->selectRaw('strftime("%m", transaction_date) as month, SUM(amount) as total')->groupBy('month')->pluck('total','month');
        $monthlyExpense = Transaction::where('type','expense')->whereYear('transaction_date', date('Y'))->selectRaw('strftime("%m", transaction_date) as month, SUM(amount) as total')->groupBy('month')->pluck('total','month');
        return Inertia::render('Reports/Index', ['stats' => $stats, 'monthlyIncome' => $monthlyIncome, 'monthlyExpense' => $monthlyExpense]);
    }
    public function members() {
        $members = Member::all();
        return Inertia::render('Reports/Members', ['members' => $members]);
    }
    public function finance() {
        $transactions = Transaction::with('member')->orderBy('transaction_date','desc')->get();
        return Inertia::render('Reports/Finance', ['transactions' => $transactions]);
    }
}
