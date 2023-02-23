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

    /**
     * get all blog posts from database
     *
     * @param  array  $params
     * @return void
     */
    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $blog = Blog::with(['user:id,name', 'comments', 'image'])->where('status', 'approved')->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $blog);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * add a blog entry to the database
     *
     * @param [post] $request
     * @return void
     */
    public function add($request)
    {
        DB::beginTransaction();
        try {
            $id = Auth::id();
            $data = Blog::create([
                'title' => $request->title,
                'slug' => str_slug($request->title),
                'content' => $request->content,
                'status' => 'pending',
                'user_id' => $id,
            ]);
            $blog = Image::create([
                'url' => $request->file('file')->store('blogs'),
                'imageable_id' => $data->id,
                'imageable_type' => \App\Models\Blog::class,
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'Blog saved successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * update blog post data to current database
     *
     * @param [update] $blog
     * @param [put] $request
     * @return void
     */
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

    /**
     * delete blog from the database and return the blog data object
     *
     * @param [delete] $blog
     * @return void
     */
    public function delete($blog)
    {
        DB::beginTransaction();
        try {
            if ($blog->delete()) {
                Image::where('imageable_id', $blog->id)->delete();
            }
            DB::commit();

            return self::jsonSuccess(message: 'Blog deleted successfully!');
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * approved blog post
     *
     * @param [approved] $id
     * @return void
     */
    public function approved($id)
    {
        DB::beginTransaction();
        try {
            $approved = Blog::with('user:id,name')->find($id);
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
