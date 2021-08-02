<?php

namespace App\Http\Resource\Common\Language;

use App\Entities\Language;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Language $this */

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}