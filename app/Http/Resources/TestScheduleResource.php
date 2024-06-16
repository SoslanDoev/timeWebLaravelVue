<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // "test" => $this->test ? $this->test->title : null,
            "test" => $this->test,
            // "group" => $this->group ? $this->group->name : null,
            "group" => $this->group,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
