<?php

namespace App\Http\Resource\Api\ZoomMeet;

use App\Entities\MeetUrl;
use App\Entities\ZoomMeet;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoomMeetApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var MeetUrl $this */
       return [
            'url_meet' => $this->getUrlMeet(),
            'id_url_meet' => $this->getId()
       ];
    }
}
