<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class CategoryController
{
    use Jsonify;

    private $categoryServices;

    public function __construct(CategoryServices $categoryServices)
    {
        $this->categoryServices = $categoryServices;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->categoryServices->search($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(CategoryRequest $request)
    {
        try {
            $data = $this->categoryServices->create($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Category $category)
    {
        try {
            $data = $this->categoryServices->show($category);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Category $category)
    {
    }

    public function update(Category $category, CategoryRequest $request)
    {
        try {
            $data = $this->categoryServices->update($category, $request);

            return self::jsonSuccess('record updated', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        try {
            $data = $this->categoryServices->destroy($category);

            return self::jsonSuccess('delete record', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
