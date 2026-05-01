<?php
namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ProjectController extends Controller {
    public function index() {
        $projects = Project::orderBy('start_date', 'desc')->paginate(15);
        return Inertia::render('Projects/Index', ['projects' => $projects]);
    }
    public function create() { return Inertia::render('Projects/Create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planning,active,completed,cancelled',
            'manager' => 'nullable|string|max:150',
        ]);
        Project::create($data);
        return redirect()->route('projects.index')->with('success', 'تم إضافة المشروع');
    }
    public function show(Project $project) { return Inertia::render('Projects/Show', ['project' => $project]); }
    public function edit(Project $project) { return Inertia::render('Projects/Edit', ['project' => $project]); }
    public function update(Request $request, Project $project) {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planning,active,completed,cancelled',
            'manager' => 'nullable|string|max:150',
        ]);
        $project->update($data);
        return redirect()->route('projects.index')->with('success', 'تم التحديث');
    }
    public function destroy(Project $project) {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'تم الحذف');
    }
}
