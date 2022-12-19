<?php

namespace App\Http\Resources\Collections\Permissions;

use App\Http\Resources\Permissions\RoleResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RolesCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'roles' => RoleResource::collection($this->collection),
            'total' => count($this->collection),
        ];
    }
}
