<?php

namespace App\Http\Resources;

use App\Traits\Resources\Filtratable;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'live' => $this->live,
            'posts_count' => $this->posts_count,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
        ]);
    }
}
