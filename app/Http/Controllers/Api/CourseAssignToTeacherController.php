<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseAssignToTeacherRequest;
use App\Models\CourseAssignToTeacher;
use App\Services\CourseAssignToTeacherServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class CourseAssignToTeacherController extends Controller
{
    use Jsonify;

    private $courseAssignToTeacherServices;

    public function __construct(CourseAssignToTeacherServices $courseAssignToTeacherServices)
    {
        parent::__permissions('course_assign_to_teachers');
        $this->courseAssignToTeacherServices = $courseAssignToTeacherServices;
    }

    public function index(CourseAssignToTeacherRequest $request)
    {
        try {
            $data = $this->courseAssignToTeacherServices->search($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(CourseAssignToTeacherRequest $request)
    {
        try {
            $data = $this->courseAssignToTeacherServices->create($request->all());

            return self::jsonSuccess(message: 'Course saved successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(CourseAssignToTeacher $courseAssignToTeacher)
    {
        try {
            $data = $this->courseAssignToTeacherServices->show($courseAssignToTeacher);

            return self::jsonSuccess(message: 'single course retrived', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(CourseAssignToTeacher $courseAssignToTeacher)
    {
    }

    public function update(Request $request, CourseAssignToTeacher $courseAssignToTeacher)
    {
        try {
            $data = $this->courseAssignToTeacherServices->update($courseAssignToTeacher, $request);

            return self::jsonSuccess(message: 'Data update successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(CourseAssignToTeacher $courseAssignToTeacher)
    {
        try {
            $data = $this->courseAssignToTeacherServices->delete($courseAssignToTeacher);

            return self::jsonSuccess(message: 'Course deleted successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
