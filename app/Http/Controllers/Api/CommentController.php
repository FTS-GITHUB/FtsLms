<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
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

    public function index(Request $request)
    {
        try {
            $comment = $this->CommentServices->search($request->all());

            return self::jsonSuccess(message: '', data: $comment);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function store(CommentRequest $request)
    {
        try {
            $comment = $this->CommentServices->create($request);

            return self::jsonSuccess(message: 'comment saved successfully!', data: $comment);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Comment $comment)
    {
        try {
            $data = $this->CommentServices->show($comment);

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function update(Request $request, $comment)
    {
        try {
            $data = $this->CommentServices->update($comment, $request);

            return self::jsonSuccess(message: '', data: $data);
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

    public function react(Request $request, $id)
    {
        try {
            $data = $this->CommentServices->react($request, $id);

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function disReact($id)
    {
        try {
            $data = $this->CommentServices->disReact($id);

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
