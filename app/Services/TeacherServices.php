<?php

namespace App\Services;

use App\Models\Teacher;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class TeacherServices extends BaseServices
{
    use Jsonify;

    public function __construct(Teacher $model)
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
            $data = Teacher::find($id);
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
            $data = Teacher::create([
                'name' => $request['name'],
                'address' => $request['address'],
                'email' => $request['email'],
                'contact_no' => $request['contact_no'],
                'designation' => $request['designation'],
            ]);
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($teacher, $request)
    {
        DB::beginTransaction();
        try {
            $data = $teacher->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

   public function destroy($teacher)
   {
       DB::beginTransaction();
       try {
           dd($teacher);
           $data = $teacher->delete();
           DB::commit();

           return self::jsonSuccess(message: 'Record deleted', data: $data);
       } catch (Exception $exception) {
           DB::rollback();

           return self::jsonError($exception->getMessage());
       }
   }
}
