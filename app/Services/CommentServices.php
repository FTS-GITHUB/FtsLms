<?php

namespace App\Services;

use App\Models\Comment;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class CommentServices extends BaseServices
{
    use Jsonify;

    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $model = $this->model;

            $model = $this->model->with('user:id,name')->paginate(10);

            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['user_id'] = auth()->user()->id;

            $comment = Comment::create($input);
            DB::commit();

            return self::jsonSuccess(message: '', data: $comment);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function replies($request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['user_id'] = auth()->user()->id;

            $comment = Comment::create($input);
            DB::commit();

            return self::jsonSuccess(message: '', data: $comment);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
