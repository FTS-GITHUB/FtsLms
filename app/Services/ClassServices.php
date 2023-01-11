<?php

namespace App\Services;

use App\Models\ClassAllocate;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class ClassServices extends BaseServices
{
    use Jsonify;

    public function __construct(ClassAllocate $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $data = $this->model->with(['departments', 'courses'])->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function add($request)
    {
        DB::beginTransaction();
        try {
            $data = ClassAllocate::create([
                'department_id' => $request['department_id'],
                'course_id' => $request['course_id'],
                'room' => $request['room'],
                'days' => $request['days'],
                'from' => $request['from'],
                'to' => $request['to'],
            ]);

            DB::commit();

            return self::jsonSuccess(message: 'Class allocate successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($classAllocate, $request)
    {
        DB::beginTransaction();
        try {
            $data = $classAllocate->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'Allocated class updated successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($classAllocate)
    {
        DB::beginTransaction();
        try {
            $data = $classAllocate->delete();
            DB::commit();

            return self::jsonSuccess(message: 'Allocated Calss deleted successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
