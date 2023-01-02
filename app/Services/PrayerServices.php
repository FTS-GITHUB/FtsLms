<?php

namespace App\Services;

use App\Models\prayer;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class prayerServices extends BaseServices
{
    use Jsonify;

    public function __construct(prayer $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $model = Prayer::with(['mosque'])->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function add($request)
    {
        DB::beginTransaction();
        try {
            $model = $this->model;
            $model::create($request->all());
            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($prayer)
    {
        DB::beginTransaction();
        try {
            $data = prayer::with(['mosque'])->find($prayer);
            DB::commit();

            return self::jsonSuccess(message: 'prayer retrived successfully!', data:$data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($prayer, $request)
    {
        DB::beginTransaction();
        try {
            $model = $this->model;
            $prayer = $model::find($prayer->id);
            $prayer->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'prayer updated successfully!', data:$prayer);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($prayer)
    {
        DB::beginTransaction();
        try {
            $data = $prayer->delete();
            DB::commit();

            return self::jsonSuccess(message: 'Record deleted successfully!', data:$data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
