<?php

namespace App\Http\Resource\Api\Teacher;

use App\Entities\TeacherInformationLanguageGrade;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherLanguagesWithNameResource extends JsonResource
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
            'language' => $this->getLanguage()->getName(),
            'grade' => $this->getLanguageGrade()->getName()
        ];
    }
}