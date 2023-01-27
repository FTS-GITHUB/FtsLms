<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Image;
use App\Traits\Jsonify;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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
            $model = $this->model->with('image')->paginate(10);
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
            $book = Book::create([
                'title' => $request->title,
                'author' => $request->author,
                'publisher' => $request->publisher,
                'upload_book' => $request->file('upload_book')->store('books'),
                'cover_image_caption' => $request->file('cover_image_caption')->store('cover_image_caption'),
                'category' => $request->category,
                'description' => $request->description,
                'remarks' => $request->remarks,
                'book_price' => $request->book_price,
                'status' => $request->status,
            ]);
            $book = Image::create([
                'url' => cloudinary()->upload($request->file('cover_image_caption')->getRealPath())->getSecurePath(),
                'imageable_id' => $book->id,
                'imageable_type' => \App\Models\Book::class,
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
            $data = Book::with('category')->find($book);
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
            $data = $book->update([
                'title' => $request->title,
                'author' => $request->author,
                'publisher' => $request->publisher,
                'upload_book' => $request->file('upload_book')->store('books'),
                'category' => $request->category,
                'description' => $request->description,
                'remarks' => $request->remarks,
                'book_price' => $request->book_price,
                'status' => $request->status,
            ]);
            if ($book) {
                $data = Image::where('imageable_id', $book->id)->first();
                dd(Cloudinary::destroy($data->id));
                if (Cloudinary::destroy($data->id)) {
                    $book = Image::create([
                        'url' => cloudinary()->upload($request->file('cover_image_caption')->getRealPath())->getSecurePath(),
                        'imageable_id' => $book->id,
                        'imageable_type' => \App\Models\Book::class,
                    ]);
                }
            }

            DB::commit();

            return self::jsonSuccess(message: 'Book updated successfully!', data: $data);
        } catch (Exception $exception) {
            dd($exception);
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
