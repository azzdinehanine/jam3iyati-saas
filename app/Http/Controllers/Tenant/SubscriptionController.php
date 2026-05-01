<?php
namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\MemberSubscription;
use App\Models\Member;
use App\Models\Plan;
use Illuminate\Http\Request;
use Inertia\Inertia;
class SubscriptionController extends Controller {
    public function index(Request $request) {
        $query = MemberSubscription::with(['member','plan']);
        if ($status = $request->input('status')) { $query->where('status', $status); }
        $subscriptions = $query->orderBy('end_date', 'desc')->paginate(15)->withQueryString();
        return Inertia::render('Subscriptions/Index', ['subscriptions' => $subscriptions, 'filters' => $request->only(['status'])]);
    }
    public function create() {
        return Inertia::render('Subscriptions/Create', [
            'members' => Member::where('status','active')->orderBy('first_name')->get(['id','first_name','last_name','member_code']),
            'plans' => Plan::where('is_active', true)->get(),
        ]);
    }
    public function store(Request $request) {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,expired,cancelled',
            'payment_method' => 'required|in:cash,bank,check,transfer',
            'notes' => 'nullable|string',
        ]);
        MemberSubscription::create($data);
        return redirect()->route('subscriptions.index')->with('success', 'تم إضافة الاشتراك');
    }
    public function show(MemberSubscription $subscription) {
        $subscription->load(['member','plan']);
        return Inertia::render('Subscriptions/Show', ['subscription' => $subscription]);
    }
    public function destroy(MemberSubscription $subscription) {
        $subscription->delete();
        return redirect()->route('subscriptions.index')->with('success', 'تم الحذف');
    }
}
