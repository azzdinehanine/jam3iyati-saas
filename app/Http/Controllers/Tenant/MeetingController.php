<?php
namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Member;
use App\Models\MeetingAttendance;
use Illuminate\Http\Request;
use Inertia\Inertia;
class MeetingController extends Controller {
    public function index() {
        $meetings = Meeting::orderBy('meeting_date', 'desc')->paginate(15);
        return Inertia::render('Meetings/Index', ['meetings' => $meetings]);
    }
    public function create() { return Inertia::render('Meetings/Create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|in:general_assembly,board,committee,other',
            'meeting_date' => 'required|date',
            'location' => 'nullable|string|max:200',
            'agenda' => 'nullable|string',
            'minutes' => 'nullable|string',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);
        Meeting::create($data);
        return redirect()->route('meetings.index')->with('success', 'تم تسجيل الاجتماع');
    }
    public function show(Meeting $meeting) {
        $meeting->load(['attendances.member']);
        $allMembers = Member::where('status','active')->orderBy('first_name')->get();
        return Inertia::render('Meetings/Show', ['meeting' => $meeting, 'allMembers' => $allMembers]);
    }
    public function edit(Meeting $meeting) { return Inertia::render('Meetings/Edit', ['meeting' => $meeting]); }
    public function update(Request $request, Meeting $meeting) {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|in:general_assembly,board,committee,other',
            'meeting_date' => 'required|date',
            'location' => 'nullable|string|max:200',
            'agenda' => 'nullable|string',
            'minutes' => 'nullable|string',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);
        $meeting->update($data);
        return redirect()->route('meetings.index')->with('success', 'تم التحديث');
    }
    public function destroy(Meeting $meeting) {
        $meeting->delete();
        return redirect()->route('meetings.index')->with('success', 'تم الحذف');
    }
    public function attend(Request $request, Meeting $meeting) {
        $data = $request->validate(['member_id' => 'required|exists:members,id', 'status' => 'required|in:present,absent,excused']);
        MeetingAttendance::updateOrCreate(['meeting_id' => $meeting->id, 'member_id' => $data['member_id']], ['status' => $data['status']]);
        return back()->with('success', 'تم تسجيل الحضور');
    }
}
