<?php

namespace App\Services;

use App\Models\Welfare;
use App\Notifications\WelfareNotification;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

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
    }

    public function add($request)
    {
        DB::beginTransaction();
        try {
            $data = Welfare::create([
                'category' => $request['category'],
                'amount' => $request['amount'],
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
            ]);
            Notification::send($data, new WelfareNotification($data));
            DB::commit();

            return self::jsonSuccess(message: 'Welfare saved successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($welfare)
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return self::jsonSuccess(message: '', data: $welfare);
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
