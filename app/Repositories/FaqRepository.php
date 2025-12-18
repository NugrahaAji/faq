<?php

namespace App\Repositories;

use App\Models\Faq;

class FaqRepository
{
    protected $model;

    public function __construct(Faq $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with(['topic', 'subTopic'])
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAllActive()
    {
        return $this->model->where('is_active', true)
            ->with(['topic', 'subTopic'])
            ->orderBy('order', 'asc')
            ->get();
    }

    public function findById($id)
    {
        return $this->model->with(['topic', 'subTopic'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $faq = $this->findById($id);
        $faq->update($data);
        return $faq;
    }

    public function delete($id)
    {
        $faq = $this->findById($id);
        return $faq->delete();
    }
}
