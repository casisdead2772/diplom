<?php


namespace App\Http\Controllers\Api\v1\Answer;


use App\Entities\Question;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\BaseController;
use App\Services\Api\Answer\AnswerApiService;
use App\Services\Api\Quiz\QuizApiService;
use App\Services\Response\Code;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AnswerController extends BaseController
{
    protected AnswerApiService $answerApiService;

    /**
     * QuizController constructor.
     * @param AnswerApiService $answerApiService
     */
    public function __construct(AnswerApiService $answerApiService)
    {
        $this->answerApiService = $answerApiService;
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
            $response = $this->answerApiService->deleteAnswer($id);
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
