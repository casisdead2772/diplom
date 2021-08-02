<?php

namespace App\Services\Api\Auth;

use App\Dto\v1\Api\User\UserStoreDto;
use App\Entities\Role;
use App\Entities\User;
use App\Exceptions\ServerErrorException;
use App\Exceptions\UnauthorizedException;
use App\Http\Resource\Api\User\UserResource;
use App\Repositories\Api\User\UserApiRepository;
use App\Repositories\Common\Acl\RoleRepository;
use App\Repositories\Common\User\UserRepository;
use App\Services\Response\Code;
use App\Services\Response\Status;
use App\Utilities\ProxyRequest;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService
{
    private EntityManager $em;
    private User $entity;
    protected UserApiRepository $userRepository;
    protected ProxyRequest $proxy;

    /**
     * AuthService constructor.
     * @param User $entity
     * @param EntityManager $em
     * @param UserApiRepository $userRepository
     * @param ProxyRequest $proxy
     */
    public function __construct(User $entity, EntityManager $em, UserApiRepository $userRepository, ProxyRequest $proxy)
    {
        $this->entity = $entity;
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->proxy = $proxy;
    }

    /**
     * @param UserStoreDto $userStoreDto
     * @return bool|string
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function registration(UserStoreDto $userStoreDto)
    {
        $this->em->getConnection()->beginTransaction(); // suspend auto-commit

        try {
            $this->entity->setEmail($userStoreDto->getEmail());
            $this->entity->setPassword($userStoreDto->getPassword());
            $this->entity->setAgreement(UserRepository::AGREEMENT);

            $this->entity->setRoles([$this->em->getReference(Role::class, RoleRepository::ROLE_USER)]);

            $this->userRepository->create($this->entity);
            //event(new Registered($this->entity));

            $this->em->getConnection()->commit();
            return true;
        } catch (\Throwable $e) {
            $this->em->getConnection()->rollBack();
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * @param UserStoreDto $userStoreDto
     * @return bool|string
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function tutorRegistration(UserStoreDto $userStoreDto)
    {
        $this->em->getConnection()->beginTransaction(); // suspend auto-commit

        try {
            $this->entity->setEmail($userStoreDto->getEmail());
            $this->entity->setPassword($userStoreDto->getPassword());
            $this->entity->setAgreement(UserRepository::AGREEMENT);

            $this->entity->setRoles([
                $this->em->getReference(Role::class, RoleRepository::ROLE_USER),
                $this->em->getReference(Role::class, RoleRepository::ROLE_TEACHER),
            ]);

            $this->userRepository->create($this->entity);

            $this->em->getConnection()->commit();
            return true;
        } catch (\Throwable $e) {
            $this->em->getConnection()->rollBack();
            throw new \RuntimeException($e->getMessage());
        }
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
            throw new ServerErrorException(Status::HTTP_INTERNAL_SERVER_ERROR, Code::HTTP_INTERNAL_SERVER_ERROR);
        }

        return [
            'access_token' => $response->access_token,
            'expires_in' => $response->expires_in,
        ];
    }


    /**
     * @return UserResource
     */
    public function getUserInfo(): UserResource
    {
        /** @var User $user */
        $user = auth()->user();

        return (new UserResource($user));
    }

    /**
     * @return array
     * @throws \JsonException
     * @throws \Exception
     */
    public function refreshToken(): array
    {
        $response = $this->proxy->refreshAccessToken();

        if (empty($response)) {
            throw new \RuntimeException(Status::UNPROCESSABLE_ENTITY);
        }

        return [
            'access_token' => $response->access_token,
            'expires_in' => $response->expires_in,
        ];
    }

    /**
     * @return mixed
     * @throws UnauthorizedException
     */
    public function logout()
    {
        $user = Auth::user()->token();

        if(empty($user)) {
            throw new UnauthorizedException([Status::UNAUTHORIZED => Status::FAILURE], Status::FAILURE);
        }

        $user->revoke();
        cookie()->queue(cookie()->forget('refresh_token'));

        return true;
    }
}
