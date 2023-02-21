<?php

namespace App\Services;

use App\Models\Round;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class RoundServices extends BaseServices
{
    use Jsonify;

    public function __construct(Round $model)
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

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $round = Round::create([
                'round' => $request['round'],
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'Round saved successfully!', data: $round);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($round)
    {
        DB::beginTransaction();
        try {
            $data = Round::find($round->id);
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($round, $request)
    {
        DB::beginTransaction();
        try {
            $round = $round->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'Round updated successfully!', data: $round);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($round)
    {
        DB::beginTransaction();
        try {
            $round = $round->delete();
            DB::commit();

            return self::jsonSuccess(message:'records deleted successfully', data:$round);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
