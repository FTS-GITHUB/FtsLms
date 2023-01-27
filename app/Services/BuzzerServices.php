<?php

namespace App\Services;

use App\Models\Buzzer;
use App\Models\BuzzerResult;
use App\Models\Option;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BuzzerServices extends BaseServices
{
    use Jsonify;

    public function __construct(Buzzer $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $model = $this->model;
            $model = $this->model->paginate(10);
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
            $data = Buzzer::create([
                'round_id' => $request['round_id'],
                'team_id' => $request['team_id'],
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'bruzzer', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function buzzers_results($request)
    {
        DB::beginTransaction();
        try {
            $data = Option::latest()->first();
            $buzzer = Buzzer::latest()->first();
            $total = $data->count();
            $obtained = $data->sum('total_marks');
            $total_mark = $total * 4;
            $obtained_mark = $obtained;
            $data = BuzzerResult::create([
                'buzzer_id' => $buzzer->id,
                'question_id' => $data->question_id,
                'total_marks' => $total_mark,
                'obtained_marks' => $obtained_mark,
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'you are great', data: 'You got '.$obtained_mark.' marks out of '.$total_mark);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    // public function show($book)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $data = Book::with('category')->find($book);
    //         DB::commit();

    //         return self::jsonSuccess(data: $data);
    //     } catch (Exception $exception) {
    //         DB::rollback();

    //         return self::jsonError($exception->getMessage());
    //     }
    // }

    // public function update($book, $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $book = $book->update([
    //             'title' => $request->title,
    //             'author' => $request->author,
    //             'publisher' => $request->publisher,
    //             'cover_image_caption' => $request->cover_image_caption,
    //             'upload_book' => $request->upload_book,
    //             'category' => $request->category,
    //             'description' => $request->description,
    //             'book_price' => $request->book_price,
    //             'remarks' => $request->remarks,
    //             'status' => $request->status,
    //         ]);

    //         DB::commit();

    //         return self::jsonSuccess(message: 'Book updated successfully!', data: $book);
    //     } catch (Exception $exception) {
    //         DB::rollback();

    //         return self::jsonError($exception->getMessage());
    //     }
    // }

    // public function delete($book)
    // {
    //     DB::beginTransaction();
    //     try {
    //         if ($book->delete()) {
    //             Storage::delete([
    //                 $book->cover_image_caption,
    //                 $book->upload_book,
    //             ]);
    //         }
    //         DB::commit();

    //         return self::jsonSuccess(message: 'Book deleted successfully!', data: $book);
    //     } catch (Exception $exception) {
    //         DB::rollback();

    //         return self::jsonError($exception->getMessage());
    //     }
    // }
}
