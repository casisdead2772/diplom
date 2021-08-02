<?php

namespace App\Http\Resource\Api\Lesson;

use App\Entities\LessonReserve;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonReserveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var LessonReserve $this */
        return [
            'id' => $this->getId(),
            'first_name' => $this->getUser()->getUserInformation()->getFirstName(),
            'last_name' => $this->getUser()->getUserInformation()->getLastName(),
            'reserved_time' => $this->getReservedTime()->getTimestamp(),
            'status' => $this->getStatus()
        ];
    }
}
