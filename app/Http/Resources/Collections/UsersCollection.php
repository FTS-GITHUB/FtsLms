<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UsersCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'collection' => UserResource::collection($this->collection),
            'total_records' => count($this->collection),
        ];
    }
}
