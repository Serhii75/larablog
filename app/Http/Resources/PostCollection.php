<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Post as PostResource;

class PostCollection extends ResourceCollection
{
    /**
     * Fields to hide
     *
     * @var array
     */
    protected $withoutFields = [];

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

    protected function processCollection($request)
    {
        return $this->collection->map(function (PostResource $resource) use ($request) {
            return $resource->hide($this->withoutFields)->toArray($request);
        })->all();
    }
}
