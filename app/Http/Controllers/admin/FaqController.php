<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FaqService;
use App\Services\TopicService;
use App\Services\SubTopicService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $faqService;
    protected $topicService;
    protected $subTopicService;

    public function __construct(
        FaqService $faqService,
        TopicService $topicService,
        SubTopicService $subTopicService
    ) {
        $this->faqService = $faqService;
        $this->topicService = $topicService;
        $this->subTopicService = $subTopicService;
    }

    public function index()
    {
        $faqs = $this->faqService->getAllFaqs();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $topics = $this->topicService->getAllActiveTopics();
        $subTopics = $this->subTopicService->getAllActiveSubTopics();
        return view('admin.faqs.create', compact('topics', 'subTopics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id' => 'required|string',
            'sub_topic_id' => 'required|string',
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'topic_id.required' => 'Topic wajib dipilih',
            'sub_topic_id.required' => 'SubTopic wajib dipilih',
            'question.required' => 'Pertanyaan wajib diisi',
            'answer.required' => 'Jawaban wajib diisi',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $this->faqService->createFaq($validated);
            return redirect()->route('admin.faqs.index')
                ->with('success', 'FAQ berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan FAQ: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $faq = $this->faqService->getFaqById($id);
        $topics = $this->topicService->getAllActiveTopics();
        $subTopics = $this->subTopicService->getSubTopicsByTopicId($faq->topic_id);
        return view('admin.faqs.edit', compact('faq', 'topics', 'subTopics'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'topic_id' => 'required|string',
            'sub_topic_id' => 'required|string',
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'topic_id.required' => 'Topic wajib dipilih',
            'sub_topic_id.required' => 'SubTopic wajib dipilih',
            'question.required' => 'Pertanyaan wajib diisi',
            'answer.required' => 'Jawaban wajib diisi',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $this->faqService->updateFaq($id, $validated);
            return redirect()->route('admin.faqs.index')
                ->with('success', 'FAQ berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate FAQ: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->faqService->deleteFaq($id);
            return redirect()->route('admin.faqs.index')
                ->with('success', 'FAQ berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
