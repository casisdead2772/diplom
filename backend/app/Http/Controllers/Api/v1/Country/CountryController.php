<?php

namespace App\Http\Controllers\Api\v1\Country;

use App\Http\Controllers\BaseController;
use App\Services\Common\Country\CountryService;
use App\Services\Response\Code;
use App\Services\Response\Error;
use App\Services\Response\Status;
use Illuminate\Support\Facades\Log;

class CountryController extends BaseController
{
    /**
     * @param CountryService $countryService
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(CountryService $countryService)
    {
        try {
            $response = $countryService->getCountriesItems();
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
