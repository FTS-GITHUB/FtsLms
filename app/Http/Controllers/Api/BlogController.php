<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Services\BlogServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use Jsonify;

    private $blogServices;

    public function __construct(BlogServices $blogServices)
    {
        parent::__permissions('blogs');
        $this->blogServices = $blogServices;
    }

    public function index(Request $request)
    {
        try {
            $blogs = $this->blogServices->search($request->all());

            return self::jsonSuccess(data: $blogs);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(BlogRequest $request)
    {
        try {
            $blog = $this->blogServices->add($request);

            return self::jsonSuccess(message: 'Blog saved successfully!', data: $blog);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Blog $blog)
    {
        try {
            $data = $blog->select('id', 'title', 'slug', 'content', 'status', 'file')->find($blog->id);

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Blog $blog)
    {
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        try {
            $blog = $this->blogServices->update($blog, $request);

            return self::jsonSuccess(message: 'Blog update successfully!', data: $blog);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Blog $blog)
    {
        try {
            $blog = $this->blogServices->delete($blog);

            return self::jsonSuccess(message: 'Blog deleted successfully!');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function approved($id)
    {
        try {
            $blog = $this->blogServices->approved($id);

            return self::jsonSuccess(message: 'Blog approved successfully!', data: $blog);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
