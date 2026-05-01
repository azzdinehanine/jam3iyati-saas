<?php
namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;
class DocumentController extends Controller {
    public function index() {
        $documents = Document::orderBy('created_at','desc')->paginate(15);
        return Inertia::render('Documents/Index', ['documents' => $documents]);
    }
    public function create() { return Inertia::render('Documents/Create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'reference_number' => 'nullable|string|max:100',
            'document_date' => 'nullable|date',
        ]);
        Document::create($data);
        return redirect()->route('documents.index')->with('success', 'تم حفظ الوثيقة');
    }
    public function destroy(Document $document) {
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'تم الحذف');
    }
}
