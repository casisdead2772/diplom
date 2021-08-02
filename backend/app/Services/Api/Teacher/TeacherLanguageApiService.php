<?php

namespace App\Services\Api\Teacher;

use App\Entities\Language;
use App\Entities\LanguageGrade;
use App\Entities\TeacherInformation;
use App\Entities\TeacherInformationLanguageGrade;
use App\Entities\User;
use App\Repositories\Api\TeacherLanguage\TeacherLanguageApiRepository;
use App\Services\AbstractService;
use Doctrine\ORM\EntityManager;

class TeacherLanguageApiService extends AbstractService
{
    private TeacherLanguageApiRepository $teacherLanguageApiRepository;

    /**
     * TeacherApiService constructor.
     * @param EntityManager $em
     * @param TeacherLanguageApiRepository $teacherLanguageApiRepository
     */
    public function __construct(EntityManager $em, TeacherLanguageApiRepository $teacherLanguageApiRepository)
    {
        parent::__construct($em);
        $this->teacherLanguageApiRepository = $teacherLanguageApiRepository;
    }

    /**
     * @param TeacherInformation $teacherInformation
     * @param Language $language
     * @param LanguageGrade $languageGrade
     */
    public function setTeacherLanguage(TeacherInformation $teacherInformation, Language $language, LanguageGrade $languageGrade)
    {
        if(empty($teacherInformation->getTeacherLanguages()->toArray())) {
            $teacherLanguage = new TeacherInformationLanguageGrade();

            $teacherLanguage->setTeacherInformation($teacherInformation);
            $teacherLanguage->setLanguage($language);
            $teacherLanguage->setLanguageGrade($languageGrade);

            return $this->teacherLanguageApiRepository->create($teacherLanguage);
        }

        /** @var TeacherInformationLanguageGrade $item */
        foreach ($teacherInformation->getTeacherLanguages()->toArray() as $item) {

            $item->setLanguage($language);
            $item->setLanguageGrade($languageGrade);

            $this->em->persist($item);
            $this->em->flush($item);
        }

        return true;
    }
}
