<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAnswerResource extends JsonResource
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
            "user" => $this->user ? $this->user->name : null,
            "question" => $this->question ? $this->question->text : null,
            "answer" => $this->answer ? $this->answer->text : null,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
