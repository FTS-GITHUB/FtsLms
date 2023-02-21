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

    /**
     * geting all data from model
     *
     * @param  array  $params
     * @return void
     */
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

    /**
     * single record display by id
     *
     * @param [get] $id
     * @return void
     */
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

    /**
     * create a new teacher record
     *
     * @param [post] $request
     * @return void
     */
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

            return self::jsonSuccess(message: 'teacher saved successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * update teacher record by id
     *
     * @param [update] $teacher
     * @param [PUT] $request
     * @return void
     */
    public function update($teacher, $request)
    {
        DB::beginTransaction();
        try {
            $data = $teacher->update([
                'name' => $request['name'],
                'address' => $request['address'],
                'email' => $request['email'],
                'contact_no' => $request['contact_no'],
                'designation' => $request['designation'],
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'teacher data updated', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

   /**
    * delete teacher data from database
    *
    * @param [delete] $teacher
    * @return void
    */
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
