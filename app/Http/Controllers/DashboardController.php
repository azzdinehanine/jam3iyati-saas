<?php
namespace App\Http\Controllers;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Meeting;
use App\Models\Project;
use App\Models\MemberSubscription;
use Inertia\Inertia;
class DashboardController extends Controller {
    public function index() {
        if (auth()->user()->isSuperAdmin()) { return redirect()->route('super.dashboard'); }
        $stats = [
            'members_total' => Member::count(),
            'members_active' => Member::where('status','active')->count(),
            'income_total' => Transaction::where('type','income')->sum('amount'),
            'expense_total' => Transaction::where('type','expense')->sum('amount'),
            'meetings_count' => Meeting::count(),
            'projects_active' => Project::where('status','active')->count(),
            'subscriptions_active' => MemberSubscription::where('status','active')->count(),
        ];
        $stats['balance'] = $stats['income_total'] - $stats['expense_total'];
        $recent_members = Member::orderBy('created_at','desc')->limit(5)->get();
        $recent_transactions = Transaction::with('member')->orderBy('transaction_date','desc')->limit(5)->get();
        return Inertia::render('Dashboard/Index', [
            'stats' => $stats,
            'recent_members' => $recent_members,
            'recent_transactions' => $recent_transactions,
        ]);
    }
}
