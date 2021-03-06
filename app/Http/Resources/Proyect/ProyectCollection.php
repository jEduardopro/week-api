<?php

namespace App\Http\Resources\Proyect;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProyectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ProyectResource::collection($this->collection);
    }
}
