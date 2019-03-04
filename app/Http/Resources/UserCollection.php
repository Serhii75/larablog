<?php

namespace App\Http\Resources;

use App\Traits\Resources\Filtratable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    use Filtratable;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->processCollection($request),
        ];
    }

    public function some_func()
    {
        if (true) {
            return [1, 2, 3];
        }
    }
}
