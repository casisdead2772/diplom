<?php

namespace App\Services\Admin\Auth;

use App\Entities\User;
use App\Exceptions\ServerErrorException;
use App\Exceptions\UnauthorizedException;
use App\Repositories\Admin\User\UserAdminRepository;
use App\Repositories\Common\Acl\RoleRepository;
use App\Services\AbstractService;
use App\Services\Common\Response\Code;
use App\Services\Common\Response\Status;
use App\Utilities\ProxyRequest;
use Doctrine\ORM\EntityManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AuthAdminService extends AbstractService
{
    const FAIL_MESSAGE = 'The email address or password you entered is incorrect';
    const PERMISSION_MESSAGE = 'Permission denied';
    const FAILED_TO_LOGIN_MESSAGE = 'Failed to login, please try again';

    private UserAdminRepository $userRepository;
    protected ProxyRequest $proxy;

    /**
     * AuthService constructor.
     * @param EntityManager $em
     * @param UserAdminRepository $userRepository
     * @param ProxyRequest $proxy
     */
    public function __construct(EntityManager $em, UserAdminRepository $userRepository, ProxyRequest $proxy)
    {
        parent::__construct($em);
        $this->userRepository = $userRepository;
        $this->proxy = $proxy;
    }

    /**
     * @param string $email
     * @param string $password
     * @return mixed
     * @throws UnauthorizedException
     * @throws \JsonException
     * @throws ServerErrorException
     */
    public function login(string $email, string $password)
    {
        /** @var User $user */
        $user = $this->userRepository->findByEmail($email);

        /*TODO message language */
        if (empty($user)) {
            throw new UnauthorizedException([Status::UNAUTHORIZED => 'Email or password incorrect'], 'Email or password incorrect', );
        }

        if (empty(Hash::check($password, $user->getPassword()))) {
            throw new UnauthorizedException([Status::UNAUTHORIZED => Status::FAILURE], 'Email or password incorrect');
        }

        $response = $this->proxy
            ->grantPasswordToken($email, $password);

        if (empty($response)) {
            throw new ServerErrorException([Status::HTTP_INTERNAL_SERVER_ERROR => Status::HTTP_INTERNAL_SERVER_ERROR], Code::HTTP_INTERNAL_SERVER_ERROR);
        }

        return [
            'access_token' => $response->access_token,
            'expires_in' => $response->expires_in,
        ];
    }

    /**
     * @return User
     */
    public function me(): User
    {
        /** @var User $user */
        $user = auth()->user();
        return $user;
    }

    /**
     * @return string|null
     * @throws BadRequestException
     */
    public function logout(): ?string
    {
        try {
            $this->guard()->logout();
            return 'Successfully logout';
        } catch(\Throwable $e) {
            throw new BadRequestException([Status::FAILURE => self::FAILED_TO_LOGIN_MESSAGE], self::FAILED_TO_LOGIN_MESSAGE, 500);
        }
    }

    /**
     * Refresh a token.
     *
     * @return array
     */
    public function refresh()
    {
        dd(auth()->user());
        return $this->buildAccessTokenData($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return array
     */
    protected function buildAccessTokenData($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
        ];
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    /**
     * @param array $data
     * @return mixed
     */
    private function checkUserRole(array $data)
    {
        $user = $this->userRepository->findOneBy([
            'email' => $data['email'],
        ]);
        return $user->hasRoleByName(RoleRepository::NAME_ADMIN);
    }
}