<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryServices extends BaseServices
{
    use Jsonify;

    public function __construct(Category $model)
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
            $category = Category::create([
                'name' => $request['name'],
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'category saved successfully!', data: $category);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($category)
    {
        DB::beginTransaction();
        try {
            $data = Category::find($category->id);
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($category, $request)
    {
        DB::beginTransaction();
        try {
            $category = $category->update([
                'name' => $request['name'],
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'category updated successfully!', data: $category);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy($category)
    {
        DB::beginTransaction();
        try {
            $category = $category->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
