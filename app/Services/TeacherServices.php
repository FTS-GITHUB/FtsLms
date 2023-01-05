<?php

namespace App\Services;

use App\Models\Teacher;
use App\Traits\Jsonify;

class TeacherServices extends BaseServices
{
    use Jsonify;

    protected $model;

    public function __construct(Teacher $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
    }

    public function show($id)
    {
        // code...
    }

    public function create($model, $request)
    {
    }

    public function update($model, $request)
    {
    }

   public function destroy($id)
   {
       // code...
   }
}
