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
    /**
     * Helper method to create return response
     */
    use Jsonify;

    /**
     * global variables for request
     *
     * @var [type]
     */
    private $questionServices;

    /**
     * load services when constructor called
     *
     * @param  QuestionServices  $questionServices
     */
    public function __construct(QuestionServices $questionServices)
    {
        parent::__permissions('questions');
        $this->questionServices = $questionServices;
    }

    /**
     * getting all questions from database
     *
     * @param  QuestionRequest  $request
     * @return void
     */
    public function index(QuestionRequest $request)
    {
        try {
            $data = $this->questionServices->saerch($request->all());

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError(message: 'some error occurred', data: $data);
        }
    }

    public function create()
    {
    }

    /**
     * store all question in database
     *
     * @param  QuestionRequest  $request
     * @return void
     */
    public function store(QuestionRequest $request)
    {
        try {
            $data = $this->questionServices->add($request->all());

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * show single question from database
     *
     * @param  Question  $question
     * @return void
     */
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

    /**
     * update question
     *
     * @param  Request  $request
     * @param  Question  $question
     * @return void
     */
    public function update(Request $request, Question $question)
    {
        try {
            $data = $this->questionServices->update($request, $question);

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception);
        }
    }

    /**
     * delete questions function
     *
     * @param  Question  $question
     * @return void
     */
    public function destroy(Question $question)
    {
        try {
            $data = $this->questionServices->delete($question);

            return self::jsonSuccess('data deleted', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception);
        }
    }

    /**
     * ask question and replay with opetion
     *
     * @param  Request  $request
     * @return void
     */
    public function games(Request $request)
    {
        try {
            $data = $this->questionServices->games($request->all());

            return self::jsonSuccess('', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception);
        }
    }

    /**
     * show results from database
     *
     * @param  Request  $request
     * @return void
     */
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
