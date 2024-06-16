<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            // "test" => $this->test ? $this->test : null,               All
            "test" => $this->test ? $this->test->title : null,
            'text' => $this->text,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
