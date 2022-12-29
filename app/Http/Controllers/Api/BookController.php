<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Services\BookServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use Jsonify;

    private $bookServices;

    public function __construct(BookServices $bookServices)
    {
        parent::__permissions('books');
        $this->bookServices = $bookServices;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->bookServices->search($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(BookRequest $request)
    {
        try {
            $book = $this->bookServices->create($request);

            return self::jsonSuccess('book saved successfully', data: $book);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Book $book)
    {
        try {
            $data = $this->bookServices->show($book);

            return self::jsonSuccess(message: 'single book retrived', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Book $book)
    {
    }

    public function update(Request $request, Book $book)
    {
        try {
            $data = $this->bookServices->update($book, $request);

            return self::jsonSuccess(message: 'book updated', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Book $book)
    {
        try {
            $data = $this->bookServices->delete($book);

            return self::jsonSuccess(message: 'book deleted', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
