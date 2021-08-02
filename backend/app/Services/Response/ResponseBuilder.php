<?php

namespace App\Services\Response;

use Illuminate\Http\Response;
use stdClass;

/**
 * Class ResponseBuilder
 * @package App\Services\Response
 *
 * @author Artyom Kostyukevich, a.kostukevich@iqeon.com
 */
class ResponseBuilder
{
    protected string $message = 'Successfully';
    protected int $code = Response::HTTP_OK;
    protected $data;
    protected $errors;
    protected bool $success = true;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function build(): \Illuminate\Http\JsonResponse
    {
        $response = [
            'message' => $this->message,
            'success' => $this->success,
            'data' => $this->data,
            'errors' => $this->errors
        ];

        return response()->json($response, $this->code);
    }

    /**
     * @param bool $data
     * @return $this
     */
    public function setSuccess(bool $data): ResponseBuilder
    {
        $this->success = $data;
        return $this;
    }

    /**
     * @param string $data
     * @return $this
     */
    public function setMessage(string $data): ResponseBuilder
    {
        $this->message = $data;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data): ResponseBuilder
    {
        $this->data = new StdClass();

        if(empty($data)) {
            $data = null;
        }

        $this->data = $data;

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setErrors($data = null): ResponseBuilder
    {
        $this->errors = $data;
        return $this;
    }

    /**
     * @param int $code
     * @return $this
     */
    public function setCode(int $code): ResponseBuilder
    {
        $this->code = $code;
        return $this;
    }
}
