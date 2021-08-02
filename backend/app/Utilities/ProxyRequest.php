<?php

namespace App\Utilities;

use App\Entities\OauthClients;
use App\Repositories\Common\Passport\OauthClientsRepository;
use Illuminate\Http\Request;

/**
 * Class ProxyRequest
 * @package App\Utilities
 * @author Kostykevich Artyom <kstartfd@gmail.com>
 */
class ProxyRequest
{
    private OauthClientsRepository $oAuthClientsRepository;

    /**
     * ProxyRequest constructor.
     * @param OauthClientsRepository $oAuthClientsRepository
     */
    public function __construct(OauthClientsRepository $oAuthClientsRepository)
    {
        $this->oAuthClientsRepository = $oAuthClientsRepository;
    }

    /**
     * @param string $email
     * @param string $password
     * @return mixed|null
     * @throws \JsonException
     */
    public function grantPasswordToken(string $email, string $password)
    {
        $data = [
            'grant_type' => 'password',
            'username' => $email,
            'password' => $password,
        ];

        return $this->makeRequest($data);
    }

    /**
     * @return mixed|null
     * @throws \JsonException
     */
    public function refreshAccessToken()
    {
        $refreshToken = request()->cookie('refresh_token');

        if(empty($refreshToken)) {
            return null;
        }

        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];

        return $this->makeRequest($data);
    }

    /**
     * @param array $data
     * @return mixed|null
     */
    protected function makeRequest(array $data)
    {
        /** @var OauthClients $client */
        $client = $this->oAuthClientsRepository->findPasswordClient();

        if (empty($client)) {
            return null;
        }

        $data = array_merge([
            'client_id' => $client->getId(),
            'client_secret' => $client->getSecret(),
            'scope' => '*',
        ], $data);

        $response = $this->createToken($data);

        if(empty($response)) {
            return null;
        }

        $this->setHttpOnlyCookie($response->refresh_token);

        return $response;
    }

    /**
     * @param string $refreshToken
     */
    protected function setHttpOnlyCookie(string $refreshToken): void
    {
        cookie()->queue(
            'refresh_token',
            $refreshToken,
            14400, // 10 days
            null,
            null,
            false,
            true // httponly
        );
    }

    /**
     * @param array $data
     * @return mixed|null
     * @throws \JsonException
     */
    protected function createToken(array $data)
    {
        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);
        if ($response->getStatusCode() !== 200) {
            return null;
        }

        return json_decode($response->getContent(), false, 512, JSON_THROW_ON_ERROR);
    }
}
