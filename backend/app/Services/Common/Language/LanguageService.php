<?php

namespace App\Services\Common\Language;

use App\Repositories\Common\Language\LanguageRepository;
use App\Repositories\Common\LanguageGrade\LanguageGradeRepository;
use App\Services\AbstractService;
use Doctrine\ORM\EntityManager;

class LanguageService extends AbstractService
{
    private LanguageRepository $languageRepository;
    private LanguageGradeRepository $languageGradeRepository;

    public function __construct(EntityManager $em, LanguageRepository $languageRepository, LanguageGradeRepository $languageGradeRepository)
    {
        parent::__construct($em);
        $this->languageRepository = $languageRepository;
        $this->languageGradeRepository = $languageGradeRepository;
    }

    /**
     * @return mixed
     */
    public function getLanguageItems()
    {
        return $this->languageRepository->getList();
    }

    /**
     * @return mixed
     */
    public function getLanguageGradeItems()
    {
        return $this->languageGradeRepository->getList();
    }
}