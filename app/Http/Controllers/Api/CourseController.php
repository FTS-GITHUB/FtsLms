<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Services\CourseServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use Jsonify;

    private $courseServices;

    public function __construct(CourseServices $courseServices)
    {
        parent::__permissions('courses');
        $this->courseServices = $courseServices;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->courseServices->search($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(CourseRequest $request)
    {
        try {
            $data = $this->courseServices->create($request->all());

            return self::jsonSuccess(message: 'Course saved successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Course $course)
    {
        try {
            $data = $this->courseServices->show($course);

            return self::jsonSuccess(message: 'single course retrived', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Course $course)
    {
    }

    public function update(CourseRequest $request, Course $course)
    {
        try {
            $data = $this->courseServices->update($course, $request);

            return self::jsonSuccess(message: 'Data update successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Course $course)
    {
        try {
            $data = $this->courseServices->delete($course);

            return self::jsonSuccess(message: 'Course deleted successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function proCourse()
    {
        try {
            $data = $this->courseServices->pro();

            return self::jsonSuccess(message: 'Course deleted successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function freeCourse()
    {
        try {
            $data = $this->courseServices->free();

            return self::jsonSuccess(message: 'Course deleted successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
