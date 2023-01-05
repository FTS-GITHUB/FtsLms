<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Image;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogServices extends BaseServices
{
    use Jsonify;

    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $blog = Blog::with(['user', 'comments', 'image'])->where('status', 'approved')->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $blog);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }

        return $blog;
    }

    public function add($request)
    {
        DB::beginTransaction();
        try {
            $id = Auth::id();
            $blog = Blog::create([
                'title' => $request->title,
                'slug' => str_slug($request->title),
                'content' => $request->content,
                'status' => 'pending',
                'user_id' => $id,
            ]);
            $blog = Image::create([
                'url' => cloudinary()->upload($request->file('file')->getRealPath())->getSecurePath(),
                'imageable_id' => $blog->id,
                'imageable_type' => \App\Models\Blog::class,
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'Blog saved successfully!', data: $blog);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($blog, $request)
    {
        DB::beginTransaction();
        try {
            $blog = $blog->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'Blog updated successfully!', data: $blog);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($blog)
    {
        DB::beginTransaction();
        try {
            $blog = $blog->delete();
            DB::commit();

            return self::jsonSuccess(message: 'Blog deleted successfully!', data: $blog);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function approved($id)
    {
        DB::beginTransaction();
        try {
            $approved = Blog::find($id);
            $approved->status = 'approved';
            if ($approved->save()) {
                DB::commit();

                return self::jsonSuccess(message: 'Blog approved successfully!', data: $approved);
            }
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
