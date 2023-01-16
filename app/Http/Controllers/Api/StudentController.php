<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Services\StudentServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use Jsonify;

    private $studentServices;

    public function __construct(StudentServices $studentServices)
    {
        parent::__permissions('students');
        $this->studentServices = $studentServices;
    }

    public function index(StudentRequest $request)
    {
        try {
            $data = $this->studentServices->search($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            $data = $this->studentServices->create($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Student $student)
    {
        try {
            return self::jsonSuccess(message: '', data: $student);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Student $student)
    {
    }

    public function update(Request $request, Student $student)
    {
        try {
            $data = $this->studentServices->update($student, $request);

            return self::jsonSuccess(message: 'Student update successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Student $student)
    {
        try {
            $data = $this->studentServices->destroy($student);

            return self::jsonSuccess(message: 'Student deleted successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
