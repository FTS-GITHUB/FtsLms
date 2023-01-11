<?php

namespace App\Services;

use App\Models\Student;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class StudentServices extends BaseServices
{
    use Jsonify;

    protected $model;

    public function __construct(Student $model)
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
            $model = $this->model;

            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $data = Student::create([
                'name' => $request['name'],
                'address' => $request['address'],
                'email' => $request['email'],
                'contact_no' => $request['contact_no'],
                'enrollment_date' => $request['enrollment_date'],
            ]);

            DB::commit();

            return self::jsonSuccess(message: 'Student saved successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($model, $request)
    {
        DB::beginTransaction();
        try {
            $data = $model->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'Student updated successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

   public function destroy($student)
   {
       DB::beginTransaction();
       try {
           $data = $student->delete();
           DB::commit();

           return self::jsonSuccess(message: 'Student deleted successfully!', data: $data);
       } catch (Exception $exception) {
           DB::rollback();

           return self::jsonError($exception->getMessage());
       }
   }
}
