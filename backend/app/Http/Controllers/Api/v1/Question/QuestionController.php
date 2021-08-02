<?php

namespace App\Http\Controllers\Api\v1\Question;

use App\Entities\Question;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Quiz\QuizApiRequest;
use App\Services\Api\Question\QuestionApiService;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class QuestionController extends BaseController
{
    protected QuestionApiService $questionApiService;

    /**
     * QuizController constructor.
     * @param QuestionApiService $questionApiService
     */
    public function __construct(QuestionApiService $questionApiService)
    {
        $this->questionApiService = $questionApiService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function store(Request $request)
    {
        try {
            $response = $this->questionApiService->createQuestion($request);
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            $response = $this->questionApiService->updateQuestion($request, $id);
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
            $response = $this->questionApiService->deleteQuestion($id);
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
