<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\Jsonify;
use Exception;

class CategoryServices extends BaseServices
{
    use Jsonify;

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        $model = $this->model;

        return $this->model->paginate(10);
    }

    public function create($request)
    {
        try {
            $blog = Category::create([
                'name' => $request['name'],
            ]);

            return self::jsonSuccess(message: 'category saved successfully!', data: $blog);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show($category)
    {
        try {
            $data = Category::find($category->id);

            return self::jsonSuccess(message: 'category saved successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function update($category, $request)
    {
        return $category = $category->update($request->all());
    }

    public function destroy($blog)
    {
        return $blog->delete();
    }

    // public function approved($id)
    // {
    //     try {
    //         $approved = Blog::find($id);
    //         $approved->status = 'approved';
    //         if ($approved->save()) {
    //             return self::jsonSuccess(message: 'User approved successfully!', data: $approved);
    //         }
    //     } catch (Exception $exception) {
    //         return self::jsonError($exception->getMessage());
    //     }
    // }
}
