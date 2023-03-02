<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRequest;
use App\Models\ClassAllocate;
use App\Services\ClassServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class ClassAllocateController extends Controller
{
    use Jsonify;

    private $classServices;

    public function __construct(ClassServices $classServices)
    {
        parent::__permissions('class_allocates');
        $this->classServices = $classServices;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->classServices->search($request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(ClassRequest $request)
    {
        try {
            $data = $this->classServices->add($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(ClassAllocate $classAllocate)
    {
        try {
            return self::jsonSuccess(message: '', data: $classAllocate);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(ClassAllocate $classAllocate)
    {
    }

    public function update(Request $request, ClassAllocate $classAllocate)
    {
        try {
            $data = $this->classServices->update($classAllocate, $request);

            return self::jsonSuccess(message: 'Allocated class update successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(ClassAllocate $classAllocate)
    {
        try {
            $data = $this->classServices->delete($classAllocate);

            return self::jsonSuccess(message: 'Allocated class deleted successfully!');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
