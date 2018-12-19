<?php

namespace App\Http\Resources;

use App\Http\Resources\{
    Post as PostResource,
    User as UserResource
};
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
            'user_id' => new UserResource($this->user),
            'post_id' => new PostResource($this->whenLoaded('post')),
            'parent_id' => $this->parent_id,
            'body' => $this->body,
            'children' => $this->children,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
