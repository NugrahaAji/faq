<?php

namespace App\Services;

use App\Repositories\TopicRepository;
use Illuminate\Support\Str;

class TopicService
{
    protected $topicRepository;

    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    public function getAllTopics()
    {
        return $this->topicRepository->getAll();
    }

    public function getAllActiveTopics()
    {
        return $this->topicRepository->getAllActive();
    }

    public function getTopicById($id)
    {
        return $this->topicRepository->findById($id);
    }

    public function createTopic(array $data)
    {
        $data['slug'] = Str::slug($data['name']);

        if (!isset($data['is_active'])) {
            $data['is_active'] = true;
        }

        return $this->topicRepository->create($data);
    }

    public function updateTopic($id, array $data)
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $this->topicRepository->update($id, $data);
    }

    public function deleteTopic($id)
    {
        $topic = $this->topicRepository->findById($id);

        if ($topic->subTopics()->count() > 0) {
            throw new \Exception('Tidak dapat menghapus topic yang memiliki sub-topic');
        }

        if ($topic->faqs()->count() > 0) {
            throw new \Exception('Tidak dapat menghapus topic yang memiliki FAQ');
        }

        return $this->topicRepository->delete($id);
    }
}
