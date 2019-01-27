<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FiltratedResourceCollection extends ResourceCollection
{
    /**
     * Fields to filter
     *
     * @var array
     */
    protected $fieldsToFiltrate = [];

    /**
     * Filter method name
     *
     * @var string
     */
    protected $filtrateMethod;

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
     * [filtrate description]
     * @param  string $filtrateMethod
     * @param  array  $fieldsToFiltrate
     * @return object $this
     */
    public function filtrate($filtrateMethod, array $fieldsToFiltrate)
    {
        $this->filtrateMethod = $filtrateMethod;
        $this->fieldsToFiltrate = $fieldsToFiltrate;

        return $this;
    }

    /**
     * Send fields to filtrate to FiltratedResource while processing the collection
     *
     * @param  $request
     * @return array
     */
    protected function processCollection($request)
    {
        return $this->collection->map(function ($resource) use ($request) {
            return $resource->filtrate($this->filtrateMethod, $this->fieldsToFiltrate)->toArray($request);
        })->all();
    }
}
