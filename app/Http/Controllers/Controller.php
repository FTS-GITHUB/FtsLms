<?php

namespace App\Http\Controllers;

use App\Helpers\GlobalHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __permissions($type)
    {
        $permissions = GlobalHelper::getResourcePermissionsMethods($type);

        foreach ($permissions as $permission) $this->middleware("can:$permission[0]", ['only' => [$permission[1]]]);
    }
}
