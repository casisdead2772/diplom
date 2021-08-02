<?php

namespace App\Rules\Api;

use App\Entities\User;
use App\Repositories\Common\Acl\RoleRepository;
use Illuminate\Contracts\Validation\Rule;
use LaravelDoctrine\ORM\Facades\EntityManager;

class NotIsTeacherRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $teacherRepository = EntityManager::getRepository(User::class);

        $teacher = $teacherRepository->findOneBy([
            'id' => $value
        ]);

        return $teacher->hasRoleByName(RoleRepository::NAME_TEACHER);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Not a teacher.';
    }
}
