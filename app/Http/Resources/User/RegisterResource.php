<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'token' => $this->createToken(request('email'))->plainTextToken,
            'user' => [
                'id' => $this->id,
                'email' => $this->email,
                'name' => $this->name,
            ],
        ];
    }
}
