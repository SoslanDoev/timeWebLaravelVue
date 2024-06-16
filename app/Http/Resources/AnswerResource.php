<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            "question" => $this->question ? $this->question->text : null,
            'text' => $this->text,
            'points' => $this->points,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
