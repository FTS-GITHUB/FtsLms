<?php

namespace App\Services;

use App\Models\Course;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class CourseServices extends BaseServices
{
    use Jsonify;

    protected $model;

    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $model = $this->model;
            $model = $this->model->with('department')->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($course)
    {
        DB::beginTransaction();
        try {
            $data = Course::with('department')->find($course);
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
            $data = Course::create([
                'department_id' => $request['department_id'],
                'course_code' => $request['course_code'],
                'course_name' => $request['course_name'],
                'course_credits' => $request['course_credits'],
                'status' => $request['status'],
                'course_description' => $request['course_description'],
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

   public function delete($course)
   {
       DB::beginTransaction();
       try {
           $data = $course->delete();
           DB::commit();

           return self::jsonSuccess(message: 'Course deleted successfully!', data: $data);
       } catch (Exception $exception) {
           DB::rollback();

           return self::jsonError($exception->getMessage());
       }
   }

   public function pro()
   {
       DB::beginTransaction();
       try {
           $model = $this->model->where('status', 'pro')->paginate('10');
           DB::commit();

           return self::jsonSuccess(message: '', data: $model);
       } catch (Exception $exception) {
           DB::rollback();

           return self::jsonError($exception->getMessage());
       }
   }

   public function free()
   {
       DB::beginTransaction();
       try {
           $model = $this->model->where('status', 'free')->paginate('10');
           DB::commit();

           return self::jsonSuccess(message: '', data: $model);
       } catch (Exception $exception) {
           DB::rollback();

           return self::jsonError($exception->getMessage());
       }
   }
}
