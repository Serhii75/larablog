<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Post as PostResource;
use Carbon\Carbon;

class Category extends FiltratedResource
{
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
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
            // 'posts' => new PostCollection($this->whenLoaded('posts')),
            'posts' => PostResource::collection($this->posts->paginate(config('larablog.per_page.posts')))->hide(['body']),
        ]);
    }
}
