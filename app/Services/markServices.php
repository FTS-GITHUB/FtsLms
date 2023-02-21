<?php

namespace App\Services;

use App\Models\Mark;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class MarkServices extends BaseServices
{
    use Jsonify;

    public function __construct(Mark $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $data = $this->model->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($mark)
    {
        DB::beginTransaction();
        try {
            $data = Mark::find($mark->id);
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $mark = Mark::create([
                'mark' => $request['mark'],
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'Mark saved successfully!', data: $mark);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($mark, $request)
    {
        DB::beginTransaction();
        try {
            $mark = $mark->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'Mark updated successfully!', data: $mark);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($mark)
    {
        DB::beginTransaction();
        try {
            $data = $mark->delete();
            DB::commit();

            return self::jsonSuccess(message: 'mark deleted successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
