<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Services\QuestionServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use Jsonify;

    private $questionServices;

    public function __construct(QuestionServices $questionServices)
    {
        parent::__permissions('questions');
        $this->questionServices = $questionServices;
    }

    public function index(QuestionRequest $request)
    {
        try {
            $data = $this->questionServices->saerch($request->all());

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError(Message: 'some error occurred', data: $data);
        }
    }

    public function create()
    {
    }

    public function store(QuestionRequest $request)
    {
        try {
            $data = $this->questionServices->add($request->all());

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Question $question)
    {
        try {
            $data = $this->questionServices->show($question);

            return self::jsonSuccess(message: 'single questions retrived', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Question $question)
    {
    }

    public function update(Request $request, Question $question)
    {
        try {
            $data = $this->questionServices->update($request, $question);

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception);
        }
    }

    public function destroy(Question $question)
    {
        try {
            $data = $this->questionServices->delete($question);

            return self::jsonSuccess('data deleted', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception);
        }
    }

    public function games(Request $request)
    {
        try {
            $data = $this->questionServices->games($request->all());

            return self::jsonSuccess('', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception);
        }
    }

    public function result(Request $request)
    {
        try {
            $data = $this->questionServices->result($request->all());

            return self::jsonSuccess('', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception);
        }
    }
}
