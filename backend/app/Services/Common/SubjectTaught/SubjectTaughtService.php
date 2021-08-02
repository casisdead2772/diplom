<?php

namespace App\Services\Common\SubjectTaught;

use App\Entities\Quiz;
use App\Entities\Specialty;
use App\Exceptions\BadRequestException;
use App\Http\Requests\Api\v1\Quiz\QuizApiRequest;
use App\Repositories\Common\Specialty\SpecialtyRepository;
use App\Services\AbstractService;
use App\Services\Response\Code;
use App\Services\Response\Status;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;

class SubjectTaughtService extends AbstractService
{
    private SpecialtyRepository $specialtyRepository;

    public function __construct(EntityManager $em, SpecialtyRepository $specialtyRepository)
    {
        parent::__construct($em);
        $this->specialtyRepository = $specialtyRepository;
    }

    /**
     * @return mixed
     */
    public function getSubjectTaughtItems()
    {
        return $this->specialtyRepository->getList();
    }
    /**
     * @param Request $request
     * @return bool
     * @throws BadRequestException
     * @throws \Doctrine\ORM\ORMException
     */
    public function createSubject(Request $request)
    {
        $name = $request->get('name');
        $code = $request->get('code');
        $this->em->getConnection()->beginTransaction();
        try {
            $spec = new Specialty();
            $spec->setCode($code);
            $spec->setName($name);
            $this->specialtyRepository->create($spec);
            $this->em->getConnection()->commit();
        } catch (\Throwable $e) {
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }
}
