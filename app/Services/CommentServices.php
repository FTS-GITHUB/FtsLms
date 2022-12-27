<?php

namespace App\Services;

use App\Models\Comment;
use App\Traits\Jsonify;

class CommentServices extends BaseServices
{
    use Jsonify;

    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        $model = $this->model;

        return $this->model->paginate(10);
    }

    public function create($request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        Comment::create($input);
    }

    public function replies($request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        Comment::create($input);
    }
}
