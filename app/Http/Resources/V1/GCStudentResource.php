<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class GCStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->userId,
            'name' => $this->profile->name->fullName
            // Keeping the code, just in case we need it.
            // 'email' => $this->profile->emailAddress
        ];
    }
}
