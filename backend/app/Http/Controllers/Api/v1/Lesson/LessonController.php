<?php

namespace App\Http\Controllers\Api\v1\Lesson;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\v1\Lesson\LessonIndexApiRequest;
use App\Http\Requests\Api\v1\Lesson\LessonStoreApiRequest;
use App\Services\Api\Lesson\LessonApiService;
use App\Services\Response\Error;
use App\Services\Response\MessageHelper;
use App\Services\Response\Status;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class LessonController extends BaseController
{
    protected LessonApiService $lessonApiService;

    /**
     * ReserveController constructor.
     * @param LessonApiService $lessonApiService
     */
    public function __construct(LessonApiService $lessonApiService)
    {
        $this->lessonApiService = $lessonApiService;
    }

    /**
     * @param LessonIndexApiRequest $lessonIndexApiRequest
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function index(LessonIndexApiRequest $lessonIndexApiRequest): ?\Illuminate\Http\JsonResponse
    {
        try {
            $response = $this->lessonApiService->getLessons($lessonIndexApiRequest);

            return $this->respBuilder()
                ->setData($response)
                ->setSuccess(true)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

    /**
     * @param LessonStoreApiRequest $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function store(LessonStoreApiRequest $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $response = $this->lessonApiService->startLesson($request);
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

    public function show(int $id): ?\Illuminate\Http\JsonResponse
    {
        try {
            $response = $this->lessonApiService->getLessonInfo($id);

            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function update(int $id)
    {
        try {
            $response = $this->lessonApiService->endLesson($id);
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (ForbiddenException $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::FORBIDDEN => $e->getMessage()]))
                ->setSuccess(false)
                ->setMessage(MessageHelper::ACCESS_NOT_PROVIDED)
                ->setCode(Response::HTTP_FORBIDDEN)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function destroy(int $id)
    {
        try {
            $response = $this->lessonApiService->cancelReservedLesson($id);

            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }
}
