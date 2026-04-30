<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Meeting;
use App\Models\Project;
use Inertia\Inertia;
class DashboardController extends Controller {
    public function index() {
        $tid = Auth::user()->tenant_id;
        $stats = [
            'members' => Member::where('tenant_id',$tid)->count(),
            'income' => Transaction::where('tenant_id',$tid)->where('type','income')->sum('amount'),
            'expenses' => Transaction::where('tenant_id',$tid)->where('type','expense')->sum('amount'),
            'meetings' => Meeting::where('tenant_id',$tid)->count(),
            'projects' => Project::where('tenant_id',$tid)->count(),
        ];
        $stats['balance'] = $stats['income'] - $stats['expenses'];
        return Inertia::render('Dashboard/Index', ['stats' => $stats]);
    }
}
