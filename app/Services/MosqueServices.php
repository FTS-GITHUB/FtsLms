<?php

namespace App\Services;

use App\Models\Mosque;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class MosqueServices extends BaseServices
{
    use Jsonify;

    public function __construct(Mosque $model)
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

    public function add($request)
    {
        DB::beginTransaction();
        try {
            $mosque = Mosque::create([
                'masjid_name' => $request->masjid_name,
                'address' => $request->address,
                'imame_name' => $request->imame_name,
                'notice_board' => $request->notice_board,
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'Mosque saved successfully!', data:$mosque);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($mosque)
    {
        DB::beginTransaction();
        try {
            $data = Mosque::find($mosque);
            DB::commit();

            return self::jsonSuccess(message: 'Mosque retrived successfully!', data:$data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($mosque, $request)
    {
        DB::beginTransaction();
        try {
            $mosque = Mosque::find($mosque->id);
            $mosque->update([
                'masjid_name' => $request->masjid_name,
                'address' => $request->address,
                'imame_name' => $request->imame_name,
                'notice_board' => $request->notice_board,
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'Mosque updated successfully!', data:$mosque);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($mosque)
    {
        DB::beginTransaction();
        try {
            $mosque = $mosque->delete();
            DB::commit();

            return self::jsonSuccess(message: 'Mosque deleted successfully!', data:$mosque);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
