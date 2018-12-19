<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Post as PostResource;

class Category extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'live' => $this->live,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'posts' => new PostCollection($this->whenLoaded('posts')),
            // 'posts' => PostResource::collection($this->posts)->paginate(24),
        ];
    }
}
