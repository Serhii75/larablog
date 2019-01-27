<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FiltratedResource extends JsonResource
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
     * Set the filtrating parameters
     *
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
     * Filtrate fields by parameters
     *
     * @param  array $data
     * @return array
     */
    protected function filtrateFields($data)
    {
        $method = $this->filtrateMethod;

        if (method_exists($this, $method)) {
            return $this->$method($data);
        }

        return $data;
    }

    /**
     * Remove the specified keys
     *
     * @param  array $data
     * @return array [description]
     */
    protected function except($data)
    {
        return collect($data)->except($this->fieldsToFiltrate)->toArray();
    }

    /**
     * Leave only the specified fields
     * @param  array $data
     * @return array
     */
    protected function only($data)
    {
        return collect($data)->only($this->fieldsToFiltrate)->toArray();
    }
}
