<?php

namespace App\Services\Api\User;

use App\Entities\User;
use App\Entities\UserInformation;
use App\Exceptions\BadRequestException;
use App\Http\Requests\Api\v1\User\UpdateUser;
use App\Http\Resource\Api\User\UserResource;
use App\Repositories\Api\User\UserApiRepository;
use App\Repositories\Api\UserInformation\UserInformationApiRepository;
use App\Services\AbstractService;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserApiService extends AbstractService
{
    private UserApiRepository $repository;
    private UserInformationApiRepository $userInformationRepository;

    /**
     * UserApiService constructor.
     * @param EntityManager $em
     * @param UserApiRepository $repository
     * @param UserInformationApiRepository $userInformationRepository
     */
    public function __construct(EntityManager $em, UserApiRepository $repository, UserInformationApiRepository $userInformationRepository)
    {
        parent::__construct($em);
        $this->repository = $repository;
        $this->userInformationRepository = $userInformationRepository;
    }

    /**
     * @return UserResource
     */
    public function getUserInfo(): UserResource
    {
        /** @var User $this */
        $user = auth()->user();

        // TODO to eager request
        return (new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUser $request
     * @param int $id
     * @return UserResource
     * @throws BadRequestException
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function updateUserInfo(UpdateUser $request, int $id): UserResource
    {
        $firstname = $request->get('first_name');
        $lastname = $request->get('last_name');
        /** @var User $user */
        $user = $this->em->getReference(User::class, $id);
        $this->em->getConnection()->beginTransaction();

        try {
            $userInformation = $user->getUserInformation();
            $user->setEmail($request->get('email'));

            $this->repository->update($user);

            if($userInformation === null) {
                $userInformation = new UserInformation();
                $userInformation->setUser($user);
                $userInformation->setFirstName($firstname);
                $userInformation->setLastName($lastname);
                $this->userInformationRepository->create($userInformation);
            }

            $userInformation->setFirstName($request->get('first_name'));
            $userInformation->setLastName($request->get('last_name'));

            $this->userInformationRepository->update($userInformation);

            $this->em->getConnection()->commit();
            return new UserResource($user);
        } catch (Throwable $e) {
            Log::critical($e->getMessage());
            $this->em->getConnection()->rollBack();
            throw new BadRequestException(['Bad request' => $e->getMessage()]);
        }
    }

    /**
     * @param User $user
     * @param UserInformation|null $userInformation
     * @param string $firstName
     * @param string $lastName
     * @return mixed
     */
    public function setUserInformation(User $user, ?UserInformation $userInformation, string $firstName, string $lastName)
    {
        if($userInformation === null) {
            $userInformation = new UserInformation();
            $userInformation->setUser($user);
            $userInformation->setFirstName($firstName);
            $userInformation->setLastName($lastName);
            return  $this->userInformationRepository->create($userInformation);
        }

        $userInformation->setFirstName($firstName);
        $userInformation->setLastName($lastName);

        return  $this->userInformationRepository->update($userInformation);
    }

    public function updateVerifiedUserInfo(int $id)
    {
        /** @var User $user */
        $user = $this->em->getReference(User::class, $id);
        $this->em->getConnection()->beginTransaction();
        try {
            $user->setEmailVerifiedAt(now());
            $this->repository->update($user);
            $this->em->getConnection()->commit();
        } catch (Throwable $e) {
            Log::critical($e->getMessage());
            $this->em->getConnection()->rollBack();
            throw new BadRequestException(['Bad request' => $e->getMessage()]);
        }

    }
}
