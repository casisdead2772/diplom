<?php

namespace App\Services\Api\Lesson;

use App\Entities\Lesson;
use App\Entities\LessonReserve;
use App\Entities\User;
use App\Exceptions\BadRequestException;
use App\Exceptions\ForbiddenException;
use App\Http\Resource\Api\Lesson\LessonApiResource;
use App\Http\Resource\Api\ZoomMeet\ZoomMeetApiResource;
use App\Repositories\Api\Lesson\Filter\LessonApiFilter;
use App\Repositories\Api\Lesson\LessonApiRepository;
use App\Repositories\Common\Lesson\LessonRepository;
use App\Repositories\Common\LessonReserve\LessonReserveRepository;
use App\Services\Api\Order\OrderApiService;
use App\Services\Api\Zoom\ZoomMeetApiService;
use App\Services\Common\Lesson\LessonService;
use App\Services\Response\Code;
use App\Services\Response\MessageHelper;
use App\Services\Response\Status;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class LessonApiService extends LessonService
{
    protected LessonApiRepository $lessonApiRepository;
    protected OrderApiService $orderApiService;
    protected ZoomMeetApiService $zoomApiService;

    /**
     * LessonApiService constructor.
     * @param EntityManager $em
     * @param Lesson $entity
     * @param LessonRepository $repository
     * @param OrderApiService $orderApiService
     * @param LessonApiRepository $lessonApiRepository
     * @param ZoomMeetApiService $zoomApiService
     */
    public function __construct(
        EntityManager $em,
        Lesson $entity,
        LessonRepository $repository,
        OrderApiService $orderApiService,
        LessonApiRepository $lessonApiRepository,
        ZoomMeetApiService $zoomApiService
    )
    {
        parent::__construct($em, $entity, $repository);
        $this->orderApiService = $orderApiService;
        $this->lessonApiRepository = $lessonApiRepository;
        $this->zoomApiService = $zoomApiService;
    }

    /**
     * @param LessonReserve $lessonReserve
     * @throws BadRequestException
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function createLesson(LessonReserve $lessonReserve)
    {
        /** @var User $teacher */
        $teacher = auth()->user();

        try {

            $this->entity->setTeacher($teacher);
            $this->entity->setUser($lessonReserve->getUser());
            $this->entity->setLessonTime($lessonReserve->getReservedTime());
            $this->entity->setStatus(LessonRepository::STATUS_NEW);

            $lesson = $this->repository->create($this->entity);

            $this->orderApiService->createOrder($lesson);

            return $lesson;

        } catch (\Throwable $e) {
            Log::critical($e->getMessage());
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getLessons(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $filter = new LessonApiFilter($request->input());

        $items = $this->lessonApiRepository->findAllByWithPaginated($user, $filter);

        LessonApiResource::collection($items);

        return $items;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function startLesson(Request $request)
    {
        $this->em->getConnection()->beginTransaction(); // suspend auto-commit

        $this->entity = $this->em->getReference(Lesson::class, $request->get('lesson_id'));
        try {
            $this->entity->setStatus(LessonRepository::STATUS_STARTED);

            /** @var Lesson $lesson */
            $lesson = $this->repository->update($this->entity);
            $result = $this->zoomApiService->createMeeting($lesson);
            $this->repository->update($result);
            $this->em->getConnection()->commit();
            return true;
        } catch (\Throwable $e) {
            Log::critical($e->getMessage());
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }

    public function endLesson(int $id)
    {
        /** @var Lesson $lesson */
        $lesson = $this->lessonApiRepository->findOneBy([
            'id' => $id
        ]);
        $this->em->getConnection()->beginTransaction();
        try {
            $lesson->setStatus(LessonRepository::STATUS_COMPLETED);
            $this->repository->update($lesson);
            $this->em->getConnection()->commit();
            return true;
        } catch (\Throwable $e) {
            Log::critical($e->getMessage());
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getLessonInfo(int $id)
    {
        /** @var Lesson $lesson */
        try {
            $lesson = $this->em->getRepository(Lesson::class)->find($id);
            $meetUrl = $lesson->getMeetUrl();
        } catch (ORMException $e) {
        }

        return $meetUrl;
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws BadRequestException
     * @throws ForbiddenException
     */
    public function cancelReservedLesson(int $id): ?bool
    {
        /** @var Lesson $lesson */
        $this->entity = $this->lessonApiRepository->findOneBy([
            'id' => $id
        ]);

        try {
            $this->entity->setStatus(LessonRepository::STATUS_CANCELED);
            $this->repository->update($this->entity);
            return true;
        } catch (\Throwable $e) {
            Log::critical($e->getMessage());
            throw new BadRequestException(['Bad request' => $e->getMessage()]);
        }
    }
}
