<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->createToken($this->email)->plainTextToken,
            'user' => [
                'id' => $this->id,
                'email' => $this->email,
                'name' => $this->name,
            ],
        ];
    }
}
