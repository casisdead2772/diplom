<?php

namespace App\Http\Resource\Api\User;

use App\Entities\User;
use App\Http\Resource\Api\Lesson\LessonReserveResource;
use App\Http\Resource\Api\Teacher\TeacherInformationResource;
use App\Http\Resource\Common\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var User $this */
        $roles = RoleResource::collection($this->getRoles()->toArray())->jsonSerialize();

        $userInfo = [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'roles' => $roles,
            'is_verified' => empty($this->getEmailVerifiedAt()) ? false : true,
            'group' =>  $this->getGroup() === null ? null : $this->getGroup()->getName(),
            'first_name' => $this->getUserInformation() === null ? null : $this->getUserInformation()->getFirstName(),
            'last_name' => $this->getUserInformation() === null ? null : $this->getUserInformation()->getLastName(),
            'created_at' => $this->getCreatedAt()->getTimestamp(),
            'updated_at' => $this->getUpdatedAt()->getTimestamp()
        ];

        if(in_array('teacher', $roles, true)) {
            $userInfo['teacher_info'] = $this->getTeacherInformation() === null ? null : (new TeacherInformationResource($this));
        }

        return $userInfo;
    }
}
