<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        Comment::create($input);

        return response()->json(['status' => 'success']);
    }

    public function show(Comment $comment)
    {
    }

    public function edit(Comment $comment)
    {
    }

    public function update(Request $request, Comment $comment)
    {
    }

    public function destroy(Comment $comment)
    {
    }
}
