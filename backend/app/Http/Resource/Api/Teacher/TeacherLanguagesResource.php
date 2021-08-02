<?php

namespace App\Http\Resource\Api\Teacher;

use App\Entities\TeacherInformationLanguageGrade;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherLanguagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var TeacherInformationLanguageGrade $this */
        return [
            'language' => $this->getLanguage()->getId(),
            'grade' => $this->getLanguageGrade()->getId(),
        ];
    }
}