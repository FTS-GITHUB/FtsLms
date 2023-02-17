<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\React;
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

    public function react($request, $id)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $user_id = auth()->user()->id;
            $data = React::create([
                'user_id' => $user_id,
                'reacts' => $request->reacts,
                'likeable_id' => $id,
                'likeable_type' => 'App/Model/Blog',
            ]);

            return self::jsonSuccess(message: 'you '.$request->reacts.' this post', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function disReact($id)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $check = React::where([
                ['user_id', '=', auth()->user()->id],
                ['likeable_id', '=', $id],
            ])->first();
            if ($check->delete()) {
                return self::jsonSuccess(message: 'react remove from your react list', data: $check);
            } else {
                return self::jsonSuccess(message: 'Some error occurred, while removing raect from your react list', data: $check);
            }
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
