<?php

namespace App\Http\Controllers\Api\v1\Quiz;

use App\Http\Controllers\BaseController;
use App\Services\Api\Quiz\QuizApiService;
use App\Services\Response\Code;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizUserController extends BaseController
{
    /**
     * @param QuizApiService $quizApiService
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(QuizApiService $quizApiService)
    {
        try {
            $response = $quizApiService->getUserQuizList();
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Code::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

}
