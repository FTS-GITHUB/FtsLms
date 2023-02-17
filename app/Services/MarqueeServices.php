<?php

namespace App\Services;

use App\Models\Marquee;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class MarqueeServices extends BaseServices
{
    use Jsonify;

    public function __construct(Marquee $model)
    {
        parent::__construct($model);
    }

    /**
     * get all marquee posts from database
     *
     * @param  array  $params
     * @return void
     */
    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $data = $this->model;
            $data = $this->model->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * add a marquee entry to the database
     *
     * @param [post] $request
     * @return void
     */
    public function add($request)
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return self::jsonSuccess(message: 'Heading update successfully!', data: '');
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * update blog post data to current database
     *
     * @param [update] $blog
     * @param [put] $request
     * @return void
     */
    public function update($marquee, $request)
    {
        DB::beginTransaction();
        try {
            $data = $marquee->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'Blog updated successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * delete blog from the database and return the blog data object
     *
     * @param [delete] $blog
     * @return void
     */
    public function delete($blog)
    {
        DB::beginTransaction();
        try {
            $blog = $blog->delete();
            DB::commit();

            return self::jsonSuccess(message: 'Heading deleted successfully!');
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * approved blog post
     *
     * @param [approved] $id
     * @return void
     */
    public function approved($id)
    {
        DB::beginTransaction();
        try {
            $approved = Marquee::find($id);
            if ($approved->status == 'pending') {
                $approved->status = 'approved';
            } else {
                $approved->status = 'pending';
            }
            if ($approved->save()) {
                DB::commit();

                return self::jsonSuccess(message: 'Header approved successfully!', data: $approved);
            }
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
