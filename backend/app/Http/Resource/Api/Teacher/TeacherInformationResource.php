<?php

namespace App\Http\Resource\Api\Teacher;

use App\Entities\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherInformationResource extends JsonResource
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
            'country' => $this->getTeacherInformation()->getCountry()->getName(),
            'description' => $this->getTeacherInformation()->getDescription(),
            'short_description' => $this->getTeacherInformation()->getShortDescription(),
            'price_per_hour' => $this->getTeacherInformation()->getPricePerHour(),
            'country_id' => $this->getTeacherInformation()->getCountry()->getId(),
            'subject_taught_id' => $this->getTeacherInformation()->getSpecialty()->getId(),
            'languages' => TeacherLanguagesResource::collection($this->getTeacherInformation()->getTeacherLanguages()->getValues())
        ];
    }
}