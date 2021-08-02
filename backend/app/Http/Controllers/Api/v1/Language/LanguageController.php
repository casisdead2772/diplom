<?php

namespace App\Http\Controllers\Api\v1\Language;

use App\Http\Controllers\BaseController;
use App\Services\Common\Language\LanguageService;
use App\Services\Response\Code;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Support\Facades\Log;

class LanguageController extends BaseController
{
    /**
     * @param LanguageService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LanguageService $service)
    {
        try {
            $response = $service->getLanguageItems();
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
