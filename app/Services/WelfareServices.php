<?php

namespace App\Services;

use App\Models\Welfare;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class WelfareServices extends BaseServices
{
    use Jsonify;

    public function __construct(Welfare $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $welfare = $this->model->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $welfare);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }

        return $blog;
    }

    public function add($request)
    {
        DB::beginTransaction();
        try {
            $data = Welfare::create([
                'category' => $request['category'],
                'amount' => $request['amount'],
                'name' => $request['name'],
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'Welfare saved successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($welfare, $request)
    {
        DB::beginTransaction();
        try {
            $data = $welfare->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'Welfare updated successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($welfare)
    {
        DB::beginTransaction();
        try {
            $data = $welfare->delete();
            DB::commit();

            return self::jsonSuccess(message: 'Welfare deleted successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
