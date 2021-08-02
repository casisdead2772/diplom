<?php

namespace App\Policies\Api\Teacher;

use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherInformationPolicy
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

    public function before(User $user, $ability)
    {
        if ($user->hasRoleByName('Teacher')) {
            return true;
        }

        return false;
    }

}
