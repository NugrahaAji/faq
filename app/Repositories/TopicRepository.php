<?php

namespace App\Repositories;

use App\Models\Topic;

class TopicRepository
{
    protected $model;

    public function __construct(Topic $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    public function getAllActive()
    {
        return $this->model->where('is_active', true)
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
        $topic = $this->findById($id);
        $topic->update($data);
        return $topic;
    }

    public function delete($id)
    {
        $topic = $this->findById($id);
        return $topic->delete();
    }
}
