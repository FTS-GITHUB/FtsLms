<?php

namespace App\Services;

use App\Models\Book;
use App\Traits\Jsonify;
use Exception;
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
        $model = $this->model;

        return $this->model->paginate(10);
    }

    public function create($request)
    {
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

            return self::jsonSuccess(message: 'Book saved successfully!', data: $book);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show($book)
    {
        try {
            $data = Book::find($book);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function update($book, $request)
    {
        try {
            return $book = $book->update($request->all());

            return self::jsonSuccess(message: 'Book updated successfully!', data: $book);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($book)
    {
        try {
            if ($book->delete()) {
                Storage::delete([
                    $book->cover_image_caption,
                    $book->upload_book,
                ]);
            }

            return self::jsonSuccess(message: 'Book deleted successfully!', data: $book);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    // public function approved($id)
    // {
    //     try {
    //         $approved = Blog::find($id);
    //         $approved->status = 'approved';
    //         if ($approved->save()) {
    //             return self::jsonSuccess(message: 'User approved successfully!', data: $approved);
    //         }
    //     } catch (Exception $exception) {
    //         return self::jsonError($exception->getMessage());
    //     }
    // }
}
