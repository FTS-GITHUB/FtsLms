<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IslamicShortStoryRequest;
use App\Models\Comment;
use App\Services\CommentServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use Jsonify;

    private $CommentServices;

    public function __construct(CommentServices $CommentServices)
    {
        parent::__permissions('comments , replies');
        $this->CommentServices = $CommentServices;
    }

    public function index()
    {
        dd('hello');
    }

    public function store(IslamicShortStoryRequest $request)
    {
        try {
            $comment = $this->CommentServices->create($request);

            return self::jsonSuccess(message: 'comment saved successfully!', data: $comment);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Comment $comment)
    {
    }

    public function replies(Request $request)
    {
        try {
            $replies = $this->CommentServices->replies($request);

            return self::jsonSuccess(message: 'replies saved successfully!', data: $replies);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
