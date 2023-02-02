<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use App\Services\MarkServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    use Jsonify;

    private $markServices;

    public function __construct(MarkServices $markServices)
    {
        parent::__permissions('marks');
        $this->markServices = $markServices;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->markServices->search($request);

            return self::jsonSuccess(data: $data);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            $data = $this->markServices->create($request);

            return self::jsonSuccess(message : 'data successfully saved', data:$data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Mark $mark)
    {
        try {
            $data = $this->markServices->show($mark);

            return self::jsonSuccess(message : '', data : $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Mark $mark)
    {
    }

    public function update(Request $request, Mark $mark)
    {
        try {
            $data = $this->markServices->update($mark, $request);

            return self::jsonSuccess(message : 'data successfully update', data:$data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Mark $mark)
    {
        try {
            $data = $this->markServices->delete($mark);

            return self::jsonSuccess(message:'data deleted successfully', data: $data);
        } catch (Exception $exception) {
            //
        }
    }
}
