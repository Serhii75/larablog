<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\{
    Category as CategoryResource,
    User as UserResource
};
use Carbon\Carbon;

class Post extends JsonResource
{
    /**
     * Fields to filter
     *
     * @var array
     */
    protected $fieldsToFilter = [];

    protected $filter;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image,
            'intro' => $this->intro,
            'body' => $this->body,
            'comments_count' => $this->comments()->count(),
            'likes_count' => $this->likes()->count(),
            'tags' => new TagCollection($this->whenLoaded('tags')),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i'),
        ]);
    }

    public function only()
    {


        return $this;
    }

    /**
     * Set the keys that are supposed to be filtered out.
     *
     * @param array $fields
     * @return $this
     */
    public function hide($fields)
    {
        $this->withoutFields = $fields;

        return $this;
    }

    /**
     * Remove the filtered keys.
     *
     * @param $array
     * @return array
     */
    protected function filterFields(array $array)
    {
        return collect($array)->forget($this->fieldsToFilter)->toArray();
    }

    public static function collection($resource)
    {
        return tap(new PostCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }
}
