<?php

namespace App\Services;

use App\Models\Mark;
use App\Models\Option;
use App\Models\Question;
use App\Models\Result;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;

class QuestionServices extends BaseServices
{
    use Jsonify;

    public function __construct(Question $model)
    {
        parent::__construct($model);
    }

    public function saerch($params = [])
    {
        DB::beginTransaction();
        try {
            $data = Question::with(['options', 'marks'])->paginate(10);

            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($question)
    {
        DB::beginTransaction();
        try {
            $data = Question::with(['options', 'marks'])->find($question);
            DB::commit();

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function add($request)
    {
        DB::beginTransaction();
        try {
            $questions = Question::create([
                'questions' => $request['question'],
            ]);

            // add options
            if ($questions) {
                $options = Option::create([
                    'option_a' => $request['option_a'],
                    'option_b' => $request['option_b'],
                    'option_c' => $request['option_c'],
                    'option_d' => $request['option_d'],
                    'correct_option' => $request['correct_option'],
                    'question_id' => $questions->id,
                ]);
                // add question marks
                if ($options) {
                    $marks = Mark::create([
                        'mark' => $request['mark'],
                        'question_id' => $questions->id,
                    ]);
                }
            }

            DB::commit();

            return self::jsonSuccess(message: 'data saved successfully!', data: $questions);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($question, $request)
    {
        DB::beginTransaction();
        try {
            $array = $question['option'];

            $options = implode(',', $array);
            $options = Option::where('id', $question->options_id)->update([
                'option' => $options,
            ]);
            if ($options) {
                $marks = Mark::where('id', $question->marks_id)->update([
                    'mark' => $request->mark,
                ]);
                if ($marks) {
                    $questions = $question->update([
                        'questions' => $request->question,
                        'options_id' => $options->id,
                        'marks_id' => $marks->id,
                    ]);
                }
            }
            DB::commit();

            return self::jsonSuccess(message: 'Question updated successfully!', data: $question);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($question)
    {
        DB::beginTransaction();
        try {
            $data = $question->delete();
            DB::commit();

            return self::jsonSuccess(message: 'data deleted successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function games($request)
    {
        DB::beginTransaction();
        try {
            $data = Option::where('question_id', $request['question_id'])->first();

            if ($data->correct_option === $request['correct_option']) {
                $data = $data->update([
                    'total_marks' => 4,
                ]);
                DB::commit();

                return self::jsonSuccess(message: 'you are great ,  you got 4 marks ', data: 'correct option'.' '.$data->correct_option);
            } else {
                $data = $data->update([
                    'total_marks' => 0,
                ]);
                DB::commit();

                return self::jsonSuccess(message: 'Oh sorry you choose wrong answer, next time better luck!', data:'correct option is'.' '.$data->correct_option);
            }
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function result($request)
    {
        DB::beginTransaction();
        try {
            $data = Option::get();
            $total = $data->count();
            $obtained = $data->sum('total_marks');

            $total_mark = $total * 4;
            $obtained_mark = $obtained;
            $data = Result::create([
                'round_id' => $request['round_id'],
                'team_id' => $request['team_id'],
                'total_mark' => $total_mark,
                'obtained_mark' => $obtained_mark,
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'you are great', data: 'You got '.$obtained_mark.' marks out of '.$total_mark);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
