<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLayoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
            'type' => $this->type,
            'h5pLib' => $this->h5pLib,
            'image' => $this->image,
            'demo_activity_id' => $this->demo_activity_id,
            'demo_video_id' => $this->demo_video_id,
            'organization_id' => $this->organization_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
