<?php

namespace App\Services\Api\Teacher;

use App\Entities\Country;
use App\Entities\Language;
use App\Entities\LanguageGrade;
use App\Entities\Specialty;
use App\Entities\TeacherInformation;
use App\Entities\User;
use App\Exceptions\BadRequestException;
use App\Http\Resource\Api\Teacher\TeachersResource;
use App\Repositories\Api\Teacher\Filter\TeacherFilter;
use App\Repositories\Api\Teacher\TeacherApiRepository;
use App\Repositories\Api\TeacherInformation\TeacherInformationApiRepository;
use App\Services\AbstractService;
use App\Services\Api\User\UserApiService;
use App\Services\Response\Code;
use App\Services\Response\Status;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;

class TeacherApiService extends AbstractService
{
    private TeacherApiRepository $teacherApiRepository;
    private TeacherInformationApiRepository $teacherInformationApiRepository;
    private UserApiService $userApiService;
    private TeacherLanguageApiService $teacherLanguageApiService;

    /**
     * TeacherApiService constructor.
     * @param EntityManager $em
     * @param TeacherApiRepository $teacherApiRepository
     * @param TeacherInformationApiRepository $teacherInformationApiRepository
     * @param UserApiService $userApiService
     * @param TeacherLanguageApiService $teacherLanguageApiService
     */
    public function __construct(EntityManager $em, TeacherApiRepository $teacherApiRepository, TeacherInformationApiRepository $teacherInformationApiRepository, UserApiService $userApiService, TeacherLanguageApiService $teacherLanguageApiService)
    {
        parent::__construct($em);
        $this->teacherApiRepository = $teacherApiRepository;
        $this->teacherInformationApiRepository = $teacherInformationApiRepository;
        $this->userApiService = $userApiService;
        $this->teacherLanguageApiService = $teacherLanguageApiService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllTeacherList(Request $request)
    {

        return $this->teacherApiRepository->findAllTeachers();
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function getTeacherList(Request $request)
    {
        $filter = new TeacherFilter($request->input());

        $items = $this->teacherApiRepository->findTeachersWithPaginate($filter);

        TeachersResource::collection($items);

        return $items;
    }

    public function setTeacherAboutInformation(Request $request, int $id)
    {
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $hourlyRate = (float)$request->get('hourly_rate');

        /** @var User $user */
        $user = $this->em->getReference(User::class, $id);
        /** @var Country $country */
        $country = $this->em->getReference(Country::class, $request->get('country_id'));
        /** @var Language $language */
        $language = $this->em->getReference(Language::class, $request->get('language_id'));
        /** @var LanguageGrade $languageGrade */
        $languageGrade = $this->em->getReference(LanguageGrade::class, $request->get('language_grade_id'));
        /** @var  Specialty $subject */
        $subject = $this->em->getReference(Specialty::class, $request->get('subject_taught_id'));

        $this->em->getConnection()->beginTransaction(); // suspend auto-commit

        try {
            $userInformation = $user->getUserInformation();

            if (empty($userInformation)) {
                $this->userApiService->setUserInformation($user, $userInformation, $firstName, $lastName);
            }

            /** @var TeacherInformation $teacherInformation */
            $teacherInformation = $user->getTeacherInformation();

            $teacherInformation = $this->setTeacherInformation($user, $teacherInformation, $country, $subject, $hourlyRate);
            $this->teacherLanguageApiService->setTeacherLanguage($teacherInformation, $language, $languageGrade);

            $this->em->getConnection()->commit();

            return true;
        } catch (\Throwable $e) {
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param User $user
     * @param TeacherInformation|null $teacherInformation
     * @param Country $country
     * @param Specialty $subject
     * @param float $hourlyRate
     */
    private function setTeacherInformation(User $user, ?TeacherInformation $teacherInformation, Country $country, Specialty $subject, float $hourlyRate)
    {
        if(empty($teacherInformation)) {
            $teacherInformation = new TeacherInformation();

            $teacherInformation->setUser($user);
            $teacherInformation->setCountry($country);
            $teacherInformation->setSpecialty($subject);
            $teacherInformation->setPricePerHour($hourlyRate);
            $this->teacherInformationApiRepository->create($teacherInformation);
            return $teacherInformation;
        }

        $teacherInformation->setCountry($country);
        $teacherInformation->setSpecialty($subject);
        $teacherInformation->setPricePerHour($hourlyRate);
        $this->teacherInformationApiRepository->update($teacherInformation);
        return $teacherInformation;
    }
}
