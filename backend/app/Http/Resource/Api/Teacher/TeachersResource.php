<?php

namespace App\Http\Resource\Api\Teacher;

use App\Entities\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TeachersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var User $this */
        return [
            'id' => $this->getId(),
            'first_name' => $this->getUserInformation()->getFirstName(),
            'last_name' => $this->getUserInformation()->getLastName(),
            'price_per_hour' => $this->getTeacherInformation()->getPricePerHour(),
            'description' => $this->getTeacherInformation()->getDescription(),
            'short_desc' => $this->getTeacherInformation()->getShortDescription(),
            'country' => $this->getTeacherInformation()->getCountry()->getName(),
            'subject' => $this->getTeacherInformation()->getSpecialty()->getName(),
            'speaks' => TeacherLanguagesWithNameResource::collection($this->getTeacherInformation()->getTeacherLanguages()->getValues())
        ];
    }
}