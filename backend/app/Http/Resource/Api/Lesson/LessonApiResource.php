<?php

namespace App\Http\Resource\Api\Lesson;

use App\Entities\Lesson;
use App\Entities\User;
use App\Repositories\Common\Acl\RoleRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var Lesson $this */
        if ($user->hasRoleByName(RoleRepository::NAME_TEACHER)) {
            return [
                'id' => $this->getId(),
                'first_name' => $this->getUser()->getUserInformation()->getFirstName(),
                'last_name' => $this->getUser()->getUserInformation()->getLastName(),
                'subject_name' =>$this->getTeacher()->getTeacherInformation()->getSpecialty()->getName(),
                'lesson_time' => $this->getLessonTime()->getTimestamp(),
                'status' => $this->getStatus()
            ];
        }

        return [
            'id' => $this->getId(),
            'first_name' => $this->getTeacher()->getUserInformation()->getFirstName(),
            'last_name' => $this->getTeacher()->getUserInformation()->getLastName(),
            'subject_name' =>$this->getTeacher()->getTeacherInformation()->getSpecialty()->getName(),
            'lesson_time' => $this->getLessonTime()->getTimestamp(),
            'status' => $this->getStatus()
        ];
    }
}
