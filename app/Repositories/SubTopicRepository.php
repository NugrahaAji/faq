<?php

namespace App\Repositories;

use App\Models\SubTopic;

class SubTopicRepository
{
    protected $model;

    public function __construct(SubTopic $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('topic')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAllActive()
    {
        return $this->model->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getByTopicId($topicId)
    {
        return $this->model->where('topic_id', $topicId)
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $subTopic = $this->findById($id);
        $subTopic->update($data);
        return $subTopic;
    }

    public function delete($id)
    {
        $subTopic = $this->findById($id);
        return $subTopic->delete();
    }
}
