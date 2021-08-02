<?php

namespace Database\Seeders;

use App\Entities\Role;
use App\Entities\TeacherInformation;
use App\Entities\User;
use App\Entities\UserGroup;
use App\Entities\UserInformation;
use App\Repositories\Common\Acl\RoleRepository;
use App\Repositories\Common\User\UserRepository;
use App\Repositories\Common\UserGroup\UserGroupRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UserTableSeed extends Seeder
{
    const TABLE = 'users';
    const USER_INFORMATION_TABLE = 'user_informations';

    private UserRepository $userRepository;

    private string $email = 'super_admin@test.com';
    private string $password = 'super_admin';
    private string $firstName = 'Full roles';
    private string $lastName = 'super_admin';

    private string $emailUser = 'user@test.com';
    private string $passwordUser = 'user';
    private string $firstNameUser = 'User';
    private string $lastNameUser = 'User';

    private string $emailTeacher = 'teacher@test.com';
    private string $passwordTeacher = 'teacher';
    private string $firstNameTeacher = 'Teacher';
    private string $lastNameTeacher = 'Teacher';

    private string $fullDescription = 'English Teacher';
    private string $shortDescription = 'English';
    private int $pricePerHour = 18;

    /**
     * UserTableSeed constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        DB::table(self::TABLE)->truncate();
        DB::table(self::USER_INFORMATION_TABLE)->truncate();

        /** @var User $user */
        $userSuper = $this->userRepository->findOneBy(['email' => $this->email]);

        $userBasic = $this->userRepository->findOneBy(['email' => $this->emailUser]);
        $userTeacher = $this->userRepository->findOneBy(['email' => $this->emailTeacher]);

        /** @var UserGroup $basicGroup */
        $basicGroup = EntityManager::getReference(UserGroup::class, UserGroupRepository::BASIC_GROUP);

        $this->createUser($userSuper, $basicGroup, $this->email, $this->password, $this->firstName, $this->lastName, RoleRepository::ROLE_ADMIN);
        $this->createUser($userBasic, $basicGroup, $this->emailUser, $this->passwordUser, $this->firstNameUser, $this->lastNameUser, RoleRepository::ROLE_USER);
        $this->createUser($userTeacher, $basicGroup, $this->emailTeacher, $this->passwordTeacher, $this->firstNameTeacher, $this->lastNameTeacher, RoleRepository::ROLE_TEACHER);
    }

    /**
     * @param User|null $user
     * @param UserGroup $group
     * @param string $email
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param int $role
     */
    private function createUser($user, UserGroup $group, string $email, string $password, string $firstName, string $lastName, int $role): void
    {
        if (empty($user)) {
            $user = new User();
            $user->setEmail($email);
            $user->setAgreement(UserRepository::AGREEMENT);
            $user->setPassword(Hash::make($password));
            $user->setGroup($group);
            EntityManager::persist($user);

            if($role === RoleRepository::ROLE_ADMIN) {
                $user->setRoles([
                    EntityManager::getReference(Role::class, RoleRepository::ROLE_USER),
                    EntityManager::getReference(Role::class, RoleRepository::ROLE_TEACHER),
                    EntityManager::getReference(Role::class, RoleRepository::ROLE_ADMIN),
                    EntityManager::getReference(Role::class, RoleRepository::ROLE_MANAGER),
                ]);
            }

            if($role === RoleRepository::ROLE_TEACHER) {
                $user->setRoles([
                    EntityManager::getReference(Role::class, RoleRepository::ROLE_USER),
                    EntityManager::getReference(Role::class, RoleRepository::ROLE_TEACHER)
                ]);
//
//                $teacherInformation = new TeacherInformation();
//                $teacherInformation->setUser($user);
//                $teacherInformation->setDescription($this->fullDescription);
//                $teacherInformation->setShortDescription($this->shortDescription);
//                $teacherInformation->setPricePerHour($this->pricePerHour);
//                $teacherInformation->setPricePerHour($this->pricePerHour);

            }

            if($role === RoleRepository::ROLE_USER) {
                $user->setRoles([
                    EntityManager::getReference(Role::class, RoleRepository::ROLE_USER)
                ]);
            }

            $userInformation = new UserInformation();
            $userInformation->setUser($user);
            $userInformation->setFirstName($firstName);
            $userInformation->setLastName($lastName);
            EntityManager::persist($userInformation);

            $user->setUserInformation($userInformation);
            EntityManager::persist($user);
            EntityManager::flush();
        }
    }
}
