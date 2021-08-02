<?php

namespace App\Services\Api\Lesson;

use App\Entities\LessonReserve;
use App\Entities\User;
use App\Exceptions\BadRequestException;
use App\Exceptions\ForbiddenException;
use App\Http\Resource\Api\Lesson\LessonApiResource;
use App\Http\Resource\Api\Lesson\LessonReserveResource;
use App\Repositories\Api\LessonReserve\Filter\LessonReserveApiFilter;
use App\Repositories\Api\LessonReserve\LessonReserveApiRepository;
use App\Repositories\Common\LessonReserve\LessonReserveRepository;
use App\Services\Common\Lesson\LessonReserveService;
use App\Services\Response\Code;
use App\Services\Response\MessageHelper;
use App\Services\Response\Status;
use DateTime;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class LessonReserveApiService extends LessonReserveService
{
    protected LessonReserveApiRepository $lessonReserveApiRepository;
    protected LessonApiService $lessonApiService;

    /**
     * LessonReserveApiService constructor.
     * @param EntityManager $em
     * @param LessonReserve $entity
     * @param LessonReserveRepository $repository
     * @param LessonReserveApiRepository $lessonReserveApiRepository
     * @param LessonApiService $lessonApiService
     */
    public function __construct(
        EntityManager $em,
        LessonReserve $entity,
        LessonReserveRepository $repository,
        LessonReserveApiRepository $lessonReserveApiRepository,
        LessonApiService $lessonApiService
    )
    {
        parent::__construct($em, $entity, $repository);
        $this->lessonReserveApiRepository = $lessonReserveApiRepository;
        $this->lessonApiService = $lessonApiService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getReservedLessons(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $filter = new LessonReserveApiFilter($request->input());

        $items = $this->lessonReserveApiRepository->findAllByWithPaginated($user, $filter);
        LessonReserveResource::collection($items);
        return $items;
    }

    /**
     * @param Request $request
     * @return bool
     * @throws BadRequestException
     * @throws \Doctrine\ORM\ORMException
     */
    public function reserveLesson(Request $request): ?bool
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var User $teacher */
        $teacher = $this->em->getReference(User::class, $request->get('teacher_id'));
        $datetime = $request->get('datetime');
        $date = strToTime($datetime);
        $datetimelesson = date_create();
        date_timestamp_set($datetimelesson, $date + 60*60*3);
        try {
            $this->entity->setUser($user);
            $this->entity->setTeacher($teacher);
            $this->entity->setStatus(LessonReserveRepository::STATUS_NEW);
            $this->entity->setReservedTime($datetimelesson);

            $this->repository->create($this->entity);

            return true;
        } catch (\Throwable $e) {
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws BadRequestException
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\ORM\ORMException
     * @throws ForbiddenException
     */
    public function confirmReservedLesson(int $id)
    {
        /** @var LessonReserve $lessonReserve */
        $this->entity = $this->lessonReserveApiRepository->findOneBy([
            'id' => $id
        ]);

        if (!Gate::allows('confirm', $this->entity)) {
            throw new ForbiddenException([Status::FAILURE => MessageHelper::ACCESS_NOT_PROVIDED], MessageHelper::ACCESS_NOT_PROVIDED, Code::FORBIDDEN);
        }

        if (!Gate::allows('update', $this->entity)) {
            throw new ForbiddenException([Status::FAILURE => MessageHelper::LESSON_RESERVE_STATUS], MessageHelper::LESSON_RESERVE_STATUS, Code::FORBIDDEN);
        }

        $this->em->getConnection()->beginTransaction(); // suspend auto-commit

        try {
            $this->entity->setStatus(LessonReserveRepository::STATUS_APPROVED);

            $reservedLesson = $this->repository->update($this->entity);

            $result = $this->lessonApiService->createLesson($reservedLesson);

            $this->em->getConnection()->commit();

            return new LessonApiResource($result);
        } catch (\Throwable $e) {
            Log::critical($e->getMessage());
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws BadRequestException
     * @throws ForbiddenException
     */
    public function revokeReservedLesson(int $id): ?bool
    {
        /** @var LessonReserve $lessonReserve */
        $this->entity = $this->lessonReserveApiRepository->findOneBy([
            'id' => $id
        ]);
        if (!Gate::allows('confirm', $this->entity)) {
            throw new ForbiddenException([Status::FAILURE => MessageHelper::ACCESS_NOT_PROVIDED], MessageHelper::ACCESS_NOT_PROVIDED, Code::FORBIDDEN);
        }

        if (!Gate::allows('update', $this->entity)) {
            throw new ForbiddenException([Status::FAILURE => MessageHelper::LESSON_RESERVE_STATUS], MessageHelper::LESSON_RESERVE_STATUS, Code::FORBIDDEN);
        }
        try {
            $this->entity->setStatus(LessonReserveRepository::STATUS_CANCELED);

            $this->repository->update($this->entity);

            return true;
        } catch (\Throwable $e) {
            Log::critical($e->getMessage());
            throw new BadRequestException(['Bad request' => $e->getMessage()]);
        }
    }

    /**
     * @return mixed
     */
    public function getReservedLessonsCount()
    {
        /** @var User $user */
        $user = auth()->user();

        return $this->lessonReserveApiRepository->findReservedCount($user);
    }
}
