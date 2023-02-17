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

    /**
     * mdoel load when constructor is called
     *
     * @param  Course  $model
     */
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    /**
     * get all courses from database
     *
     * @param  get  $params
     * @return void
     */
    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $model = $this->model;
            $model = $this->model->with(['department', 'teachers', 'courses'])->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * getting single  courses from database
     *
     * @param [Course] $course
     * @return void
     */
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

    /**
     * create a new Course object from
     *
     * @param [post] $request
     * @return void
     */
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

    /**
     * update course
     *
     * @param [course] $model
     * @param [put] $request
     * @return void
     */
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

   /**
    * delete course by id
    *
    * @param [delete] $course
    * @return void
    */
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

   /**
    * pro courses retrived from database
    *
    * @return void
    */
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

   /**
    * free courses retrived from database
    *
    * @return void
    */
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
