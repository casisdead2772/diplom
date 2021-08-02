<?php


namespace App\Http\Controllers\Api\v1\Subject;


use App\Http\Controllers\BaseController;
use App\Services\Common\SubjectTaught\SubjectTaughtService;
use App\Services\Response\Code;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class SubjectAddController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param SubjectTaughtService $service
     * @return JsonResponse
     */
    public function store(Request $request, SubjectTaughtService $service)
    {
        try {
            $response = $service->createSubject($request);
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => $e->getMessage()]))
                ->setSuccess(false)
                ->setCode(Code::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

}
