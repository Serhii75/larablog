<?php

namespace App\Http\Resources;

use App\Traits\Resources\Filtratable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
}
