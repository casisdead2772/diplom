<?php

namespace App\Http\Controllers\Api\v1\Subject;

use App\Http\Controllers\BaseController;
use App\Services\Response\Code;
use App\Services\Response\Error;
use App\Services\Response\Status;
use App\Services\Common\SubjectTaught\SubjectTaughtService;
use Illuminate\Support\Facades\Log;

class SubjectController extends BaseController
{
    /**
     * @param SubjectTaughtService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(SubjectTaughtService $service)
    {
        try {
            $response = $service->getSubjectTaughtItems();
            return $this->respBuilder()
                ->setData($response)
                ->build();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return $this->respBuilder()
                ->setErrors(Error::errors([Status::HTTP_INTERNAL_SERVER_ERROR => 'Server error.']))
                ->setSuccess(false)
                ->setCode(Code::HTTP_INTERNAL_SERVER_ERROR)
                ->build();
        }
    }

}
