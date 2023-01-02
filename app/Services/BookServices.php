<?php

namespace App\Services;

use App\Models\Book;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookServices extends BaseServices
{
    use Jsonify;

    public function __construct(Book $model)
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

            return self::jsonSuccess(message: 'Book saved successfully!', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $cover_image = $request->file('cover_image_caption')->store('book_cover_image');

            $book = Book::create([
                'title' => $request->title,
                'author' => $request->author,
                'publisher' => $request->publisher,
                'cover_image_caption' => $cover_image,
                'upload_book' => $request->file('upload_book')->store('books'),
                'category' => $request->category,
                'description' => $request->description,
                'remar' => $request->remarks,
                'book_price' => $request->book_price,
                'status' => $request->status,
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'Book saved successfully!', data: $book);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function show($book)
    {
        DB::beginTransaction();
        try {
            $data = Book::find($book);
            DB::commit();

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($book, $request)
    {
        DB::beginTransaction();
        try {
            $book = $book->update($request->all());
            dd($book);
            DB::commit();

            return self::jsonSuccess(message: 'Book updated successfully!', data: $book);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($book)
    {
        DB::beginTransaction();
        try {
            if ($book->delete()) {
                Storage::delete([
                    $book->cover_image_caption,
                    $book->upload_book,
                ]);
            }
            DB::commit();

            return self::jsonSuccess(message: 'Book deleted successfully!', data: $book);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
