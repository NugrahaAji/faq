<?php

namespace App\Services;

use App\Repositories\FaqRepository;

class FaqService
{
    protected $faqRepository;

    public function __construct(FaqRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    public function getAllFaqs()
    {
        return $this->faqRepository->getAll();
    }

    public function getAllActiveFaqs()
    {
        return $this->faqRepository->getAllActive();
    }

    public function getFaqById($id)
    {
        return $this->faqRepository->findById($id);
    }

    public function createFaq(array $data)
    {
        if (!isset($data['order'])) {
            $data['order'] = 0;
        }

        if (!isset($data['is_active'])) {
            $data['is_active'] = true;
        }

        return $this->faqRepository->create($data);
    }

    public function updateFaq($id, array $data)
    {
        return $this->faqRepository->update($id, $data);
    }

    public function deleteFaq($id)
    {
        return $this->faqRepository->delete($id);
    }
}
