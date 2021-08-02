<?php


namespace App\Http\Resource\Api\Quiz;


use App\Entities\Quiz;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Quiz $this */
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'questions' => $this->getQuestion()
        ];
    }
}
