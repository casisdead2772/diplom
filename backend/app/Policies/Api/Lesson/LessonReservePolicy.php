<?php

namespace App\Policies\Api\Lesson;

use App\Entities\LessonReserve;
use App\Entities\User;
use App\Repositories\Common\Acl\RoleRepository;
use App\Repositories\Common\LessonReserve\LessonReserveRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

class LessonReservePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $user
     * @param LessonReserve $lesson
     * @return bool
     */
    public function confirm(User $user, LessonReserve $lesson): bool
    {
        return $user->hasRoleByName(RoleRepository::NAME_TEACHER) && $user->getId() === $lesson->getTeacher()->getId();
    }

    /**
     * @param User $user
     * @param LessonReserve $lesson
     * @return bool
     */
    public function update(User $user, LessonReserve $lesson): bool
    {
        return $lesson->getStatus() === LessonReserveRepository::STATUS_NEW;
    }

    public function delete(User $user, LessonReserve $lesson)
    {
        return $user === $lesson->getUser();
    }
}