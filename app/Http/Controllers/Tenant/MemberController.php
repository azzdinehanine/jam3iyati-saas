<?php
namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Inertia\Inertia;
class MemberController extends Controller {
    public function index(Request $request) {
        $query = Member::query();
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('lastname', 'like', "%$search%")->orWhere('email', 'like', "%$search%")->orWhere('phone', 'like', "%$search%");
            });
        }
        if ($status = $request->input('status')) { $query->where('status', $status); }
        $members = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        return Inertia::render('Members/Index', ['members' => $members, 'filters' => $request->only(['search', 'status'])]);
    }
    public function create() { return Inertia::render('Members/Create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'cin' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|in:M,F',
            'address' => 'nullable|string',
            'role_in_assoc' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,left',
            'join_date' => 'required|date',
        ]);
        Member::create($data);
        return redirect()->route('members.index')->with('success', 'تم إضافة العضو بنجاح');
    }
    public function show(Member $member) { return Inertia::render('Members/Show', ['member' => $member]); }
    public function edit(Member $member) { return Inertia::render('Members/Edit', ['member' => $member]); }
    public function update(Request $request, Member $member) {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'cin' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|in:M,F',
            'address' => 'nullable|string',
            'role_in_assoc' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,left',
            'join_date' => 'required|date',
        ]);
        $member->update($data);
        return redirect()->route('members.index')->with('success', 'تم التحديث');
    }
    public function destroy(Member $member) {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'تم الحذف');
    }
}
