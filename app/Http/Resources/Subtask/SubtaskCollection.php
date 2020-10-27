<?php

namespace App\Http\Resources\Subtask;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubtaskCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
