<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $this->duration,
            "discipline" => $this->discipline ? $this->discipline->name : null,
            "author" => $this->author ? $this->author->name : null,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
