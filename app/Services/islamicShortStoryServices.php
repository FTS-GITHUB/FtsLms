<?php

namespace App\Services;

use App\Models\IslamicShortStory;
use App\Traits\Jsonify;

class islamicShortStoryServices extends BaseServices
{
    use Jsonify;

    public function __construct(IslamicShortStory $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        $model = $this->model;

        return $this->model->paginate(10);
    }

    public function show($id)
    {
        $data = IslamicShortStory::find($id);

        return $data;
    }

    public function create($request)
    {
        $input = $request->all();

        return IslamicShortStory::create($input);
    }

    public function update($request, $data)
    {
        $input = $request->all();

        return IslamicShortStory::where('id', $data['id'])->update($input);
    }
}
