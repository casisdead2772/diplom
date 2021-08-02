<?php

namespace App\Http\Controllers;

use App\Services\Response\ResponseBuilder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseController
 * @package App\Http\Controllers
 * @author Kostykevich Artyom <kstartfd@gmail.com>
 */
abstract class BaseController extends Controller
{
    final public function respBuilder()
    {
        return new ResponseBuilder();
    }

    /**
     * @OA\Info(
     *  title="MyProfit API",
     *  version="1.0.0",
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     * @OA\Tag(
     *      name="Auth",
     *      description=""
     * )
     * @OA\Tag(
     *      name="User",
     *      description=""
     * )
     * @OA\Server(
     *      description="MyProfit API server",
     *      url="https://backend-myprofit.iqeon.dev"
     * )
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Login with email and password to get the authentication token",
     *     name="Token based",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="apiAuth",
     * )
     * @param string $status
     * @param string $message
     * @param int $statusCode
     * @param null $data
     * @param null $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond(
        string $status,
        string $message,
        int $statusCode = Response::HTTP_OK,
        $data = null,
        $errors = null
    ): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => $errors
        ], $statusCode);
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}
