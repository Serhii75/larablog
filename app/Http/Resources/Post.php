<?php

namespace App\Http\Resources;

use App\Traits\Resources\Filtratable;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\User as UserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
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
            'user' => (new UserResource($this->user))->only('id', 'name'),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image,
            'intro' => $this->intro,
            'body' => $this->body,
            'comments_count' => $this->comments_count ?? $this->comments()->count(),
            'likes_count' => $this->likes_count ?? $this->likes()->count(),
            'tags' => new TagCollection($this->whenLoaded('tags')),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i'),
        ]);
    }
}
