<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;
use App\Services\TeacherServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    use Jsonify;

    private $teacherServices;

    public function __construct(TeacherServices $teacherServices)
    {
        parent::__permissions('teachers');
        $this->teacherServices = $teacherServices;
    }

    public function index(Request $request)
    {
        try {
            $teacher = $this->teacherServices->search($request->all());

            return self::jsonSuccess(data: $teacher);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(TeacherRequest $request)
    {
        try {
            $teacher = $this->teacherServices->add($request->all());

            return self::jsonSuccess(message: 'teacher saved successfully!', data: $teacher);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Teacher $teacher)
    {
        try {
            $teacher = $this->teacherServices->show($teacher);

            return self::jsonSuccess(message: 'teacher saved successfully!', data: $teacher);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Teacher $teacher)
    {
    }

    public function update(Request $request, Teacher $teacher)
    {
        try {
            $teacher = $this->teacherServices->update($teacher, $request);

            return self::jsonSuccess(message: 'teacher saved successfully!', data: $teacher);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Teacher $teacher)
    {
        try {
            $data = $teacher->delete($teacher);

            return self::jsonSuccess(message: 'teacher delete successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
