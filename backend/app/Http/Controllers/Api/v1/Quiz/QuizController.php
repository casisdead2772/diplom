<?php

namespace App\Http\Controllers\Api\v1\Quiz;

use App\Entities\Quiz;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Lesson\LessonReserveIndexApiRequest;
use App\Http\Requests\Api\v1\Quiz\QuizApiRequest;
use App\Services\Api\Quiz\QuizApiService;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class QuizController extends BaseController
{
    protected QuizApiService $quizApiService;

    /**
     * QuizController constructor.
     * @param QuizApiService $quizApiService
     */
    public function __construct(QuizApiService $quizApiService)
    {
        $this->quizApiService = $quizApiService;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function index(Request $request)
    {
        try {
            $response = $this->quizApiService->getQuizzes($request);

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuizApiRequest  $quizApiRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(QuizApiRequest $quizApiRequest)
    {
                try {
                    $response = $this->quizApiService->createQuiz($quizApiRequest);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $response = $this->quizApiService->getQuiz($id);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $response = $this->quizApiService->updateQuiz($request, $id);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $response = $this->quizApiService->deleteQuiz($id);
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
