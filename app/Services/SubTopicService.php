<?php

namespace App\Services;

use App\Repositories\SubTopicRepository;
use Illuminate\Support\Str;

class SubTopicService
{
    protected $subTopicRepository;

    public function __construct(SubTopicRepository $subTopicRepository)
    {
        $this->subTopicRepository = $subTopicRepository;
    }

    public function getAllSubTopics()
    {
        return $this->subTopicRepository->getAll();
    }

    public function getAllActiveSubTopics()
    {
        return $this->subTopicRepository->getAllActive();
    }

    public function getSubTopicsByTopicId($topicId)
    {
        return $this->subTopicRepository->getByTopicId($topicId);
    }

    public function getSubTopicById($id)
    {
        return $this->subTopicRepository->findById($id);
    }

    public function createSubTopic(array $data)
    {
        $data['slug'] = Str::slug($data['name']);

        if (!isset($data['is_active'])) {
            $data['is_active'] = true;
        }

        return $this->subTopicRepository->create($data);
    }

    public function updateSubTopic($id, array $data)
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $this->subTopicRepository->update($id, $data);
    }

    public function deleteSubTopic($id)
    {
        $subTopic = $this->subTopicRepository->findById($id);

        if ($subTopic->faqs()->count() > 0) {
            throw new \Exception('Tidak dapat menghapus sub-topic yang memiliki FAQ');
        }

        return $this->subTopicRepository->delete($id);
    }
}
