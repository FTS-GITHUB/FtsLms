<?php

namespace App\Services;

use App\Models\CourseAssignToTeacher;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class CourseAssignToTeacherServices extends BaseServices
{
    use Jsonify;

    protected $model;

    public function __construct(CourseAssignToTeacher $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $model = $this->model;
            $model = $this->model->with(['teacher', 'course', 'course.department'])->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($courseAssignToTeacher)
    {
        DB::beginTransaction();
        try {
            $data = CourseAssignToTeacher::with(['teacher', 'course', 'course.department'])->find($courseAssignToTeacher);
            DB::commit();

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $data = CourseAssignToTeacher::create([
                'teacher_id' => $request['teacher_id'],
                'course_id' => $request['course_id'],
                'creadit' => $request['creadit'],
            ]);

            DB::commit();

            return self::jsonSuccess(message: 'Course saved successfully!', data: $data);
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

            return self::jsonSuccess(message: 'Course updated successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

   public function delete($courseAssignToTeacher)
   {
       DB::beginTransaction();
       try {
           $data = $courseAssignToTeacher->delete();
           DB::commit();

           return self::jsonSuccess(message: 'Course deleted successfully!', data: $data);
       } catch (Exception $exception) {
           DB::rollback();

           return self::jsonError($exception->getMessage());
       }
   }
}
