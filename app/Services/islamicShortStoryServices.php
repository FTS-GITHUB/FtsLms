<?php

namespace App\Services;

use App\Models\IslamicShortStory;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class islamicShortStoryServices extends BaseServices
{
    use Jsonify;

    public function __construct(IslamicShortStory $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $model = $this->model;

            $model = $this->model->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $data = IslamicShortStory::find($id);
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function create($request)
    {
        try {
            $input = $request->all();

            $input = IslamicShortStory::create($input);

            return self::jsonSuccess(message: '', data: $input);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($request, $data)
    {
        try {
            $input = $request->all();

            $input = IslamicShortStory::where('id', $data['id'])->update($input);

            return self::jsonSuccess(message: '', data: $input);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
