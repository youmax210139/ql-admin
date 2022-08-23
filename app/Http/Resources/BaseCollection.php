<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseCollection extends ResourceCollection
{
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'code' => 200
        ];
    }
}
