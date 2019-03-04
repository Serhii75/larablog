<?php

namespace App\Http\Resources;

use App\Traits\Resources\Filtratable;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    use Filtratable;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->filtrateFields([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'isAdmin' => $this->isAdmin(),
        ]);
    }
