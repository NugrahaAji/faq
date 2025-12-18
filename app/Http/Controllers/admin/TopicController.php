<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TopicService;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    protected $topicService;

    public function __construct(TopicService $topicService)
    {
        $this->topicService = $topicService;
    }

    public function index()
    {
        $topics = $this->topicService->getAllTopics();
        return view('admin.topics.index', compact('topics'));
    }

    public function create()
    {
        return view('admin.topics.create');
    }

    public function store(Request $request)
    {
        // Validasi dengan unique check
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:topics,name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama topic wajib diisi',
            'name.unique' => 'Topic dengan nama ini sudah ada',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $topic = $this->topicService->createTopic($validated);

            // Return JSON jika AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Topic berhasil ditambahkan',
                    'data' => $topic
                ]);
            }

            return redirect()->route('admin.topics.index')
                ->with('success', 'Topic berhasil ditambahkan!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal menambahkan topic: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $topic = $this->topicService->getTopicById($id);
        return view('admin.topics.edit', compact('topic'));
    }

    public function update(Request $request, $id)
    {
        // Validasi dengan unique kecuali ID sendiri
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:topics,name,' . $id . ',_id',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama topic wajib diisi',
            'name.unique' => 'Topic dengan nama ini sudah ada',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $this->topicService->updateTopic($id, $validated);
            return redirect()->route('admin.topics.index')
                ->with('success', 'Topic berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate topic: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->topicService->deleteTopic($id);
            return redirect()->route('admin.topics.index')
                ->with('success', 'Topic berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
