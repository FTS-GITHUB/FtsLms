<?php

namespace App\Services;

use App\Models\Blog;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\Auth;

class BlogServices extends BaseServices
{
    use Jsonify;

    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        $query = Blog::where('status', 'approved')->paginate(10);

        return $query;
    }

    // public function create()
    // {
    //     $roles = Role::pluck('name', 'name')->all();

    //     return $roles;
    // }

    public function add($request)
    {
        try {
            $id = Auth::id();
            $blog = Blog::create([
                'title' => $request->title,
                'slug' => str_slug($request->title),
                'content' => $request->content,
                'status' => 'pending',
                'user_id' => $id,
            ]);

            return self::jsonSuccess(message: 'User saved successfully!', data: $blog);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function update($blog, $request)
    {
        return $blog = $blog->update($request->all());
    }

    public function delete($blog)
    {
        return $blog->delete();
    }

    public function approved($id)
    {
        try {
            $approved = Blog::find($id);
            $approved->status = 'approved';
            if ($approved->save()) {
                return self::jsonSuccess(message: 'User approved successfully!', data: $approved);
            }
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
