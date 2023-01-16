<?php

namespace App\Services;

use App\Models\Department;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class DepartmentServices extends BaseServices
{
    use Jsonify;

    public function __construct(Department $model)
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

    public function add($request)
    {
        DB::beginTransaction();
        try {
            $data = Department::create([
                'department_code' => $request['department_code'],
                'department_name' => $request['department_name'],
            ]);

            DB::commit();

            return self::jsonSuccess(message: 'Department saved successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($model, $request)
    {
        DB::beginTransaction();
        try {
            $model = $model->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'Department updated successfully!', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($department)
    {
        DB::beginTransaction();
        try {
            $data = $department->delete();
            DB::commit();

            return self::jsonSuccess(message: 'Blog deleted successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
