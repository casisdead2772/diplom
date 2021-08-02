<?php

namespace App\Http\Resource\Common\Role;

use App\Entities\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource  extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Role $this */
        return $this->getName();
    }
}
