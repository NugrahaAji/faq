<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SubTopicService;
use App\Services\TopicService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubTopicController extends Controller
{
    protected $subTopicService;
    protected $topicService;

    public function __construct(
        SubTopicService $subTopicService,
        TopicService $topicService
    ) {
        $this->subTopicService = $subTopicService;
        $this->topicService = $topicService;
    }

    public function index()
    {
        $subTopics = $this->subTopicService->getAllSubTopics();
        return view('admin.subtopics.index', compact('subTopics'));
    }

    public function create()
    {
        $topics = $this->topicService->getAllActiveTopics();
        return view('admin.subtopics.create', compact('topics'));
    }

    public function store(Request $request)
    {
        // Validasi: nama subtopic harus unique dalam 1 topic yang sama
        $validated = $request->validate([
            'topic_id' => 'required|string',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_topics', 'name')->where(function ($query) use ($request) {
                    return $query->where('topic_id', $request->topic_id);
                })
            ],
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama subtopic wajib diisi',
            'name.unique' => 'SubTopic dengan nama ini sudah ada di topic yang dipilih',
            'topic_id.required' => 'Topic wajib dipilih',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $subTopic = $this->subTopicService->createSubTopic($validated);

            // Return JSON jika AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'SubTopic berhasil ditambahkan',
                    'data' => $subTopic
                ]);
            }

            return redirect()->route('admin.subtopics.index')
                ->with('success', 'Sub-Topic berhasil ditambahkan!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal menambahkan sub-topic: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $subTopic = $this->subTopicService->getSubTopicById($id);
        $topics = $this->topicService->getAllActiveTopics();
        return view('admin.subtopics.edit', compact('subTopic', 'topics'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'topic_id' => 'required|string',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_topics', 'name')->where(function ($query) use ($request) {
                    return $query->where('topic_id', $request->topic_id);
                })->ignore($id, '_id')
            ],
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama subtopic wajib diisi',
            'name.unique' => 'SubTopic dengan nama ini sudah ada di topic yang dipilih',
            'topic_id.required' => 'Topic wajib dipilih',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $this->subTopicService->updateSubTopic($id, $validated);
            return redirect()->route('admin.subtopics.index')
                ->with('success', 'Sub-Topic berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate sub-topic: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->subTopicService->deleteSubTopic($id);
            return redirect()->route('admin.subtopics.index')
                ->with('success', 'Sub-Topic berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getByTopic($topicId)
    {
        try {
            $subTopics = $this->subTopicService->getSubTopicsByTopicId($topicId);
            return response()->json($subTopics);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
