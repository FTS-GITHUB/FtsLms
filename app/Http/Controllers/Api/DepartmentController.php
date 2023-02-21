<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use Jsonify;

    private $departmentServices;

    public function __construct(DepartmentServices $departmentServices)
    {
        parent::__permissions('departments');
        $this->departmentServices = $departmentServices;
    }
/**
 * getting all department data from database
 *
 * @param Request $request
 * @return void
 */
    public function index(Request $request)
    {
        try {
            $data = $this->departmentServices->search($request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
    }

    public function store(DepartmentRequest $request)
    {
        try {
            $data = $this->departmentServices->add($request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Department $department)
    {
        try {
            return self::jsonSuccess(message: '', data: $department);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Department $department)
    {
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        try {
            $data = $this->departmentServices->update($department, $request);

            return self::jsonSuccess(message: 'Department update successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Department $department)
    {
        try {
            $blog = $this->departmentServices->delete($department);

            return self::jsonSuccess(message: 'Deparment deleted successfully!');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
