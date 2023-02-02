<?php

namespace App\Services;

use App\Models\prayer;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class prayerServices extends BaseServices
{
    use Jsonify;

    public function __construct(prayer $model)
    {
        parent::__construct($model);
    }

    /**
     * get all prayer data from database
     *
     * @param  prayer  $model
     */
    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $model = Prayer::with(['mosque:id,masjid_name,address,notice_board'])->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * create a new prayer
     *
     * @param [post] $request
     * @return void
     */
    public function add($request)
    {
        DB::beginTransaction();
        try {
            $model = $this->model;
            $data = $model::create($request->all());
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * show all records in the table
     *
     * @param [get] $prayer
     * @return void
     */
    public function show($prayer)
    {
        DB::beginTransaction();
        try {
            $data = prayer::with(['mosque:id,masjid_name,address,notice_board'])->find($prayer);
            DB::commit();

            return self::jsonSuccess(message: 'prayer retrived successfully!', data:$data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * update a prayer data from database
     *
     * @param [update] $prayer
     * @param [PUT] $request
     * @return void
     */
    public function update($prayer, $request)
    {
        DB::beginTransaction();
        try {
            $model = $this->model;
            $prayer = $model::find($prayer->id);
            $prayer->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'prayer updated successfully!', data:$prayer);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * delete a prayer data from database
     *
     * @param [delete] $prayer
     * @return void
     */
    public function delete($prayer)
    {
        DB::beginTransaction();
        try {
            $data = $prayer->delete();
            DB::commit();

            return self::jsonSuccess(message: 'Record deleted successfully!', data:$data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
