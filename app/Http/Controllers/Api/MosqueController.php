<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use App\Services\MosqueServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class MosqueController extends Controller
{
    use Jsonify;

    private $mosqueServices;

    public function __construct(MosqueServices $mosqueServices)
    {
        parent::__permissions('mosques');
        $this->mosqueServices = $mosqueServices;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->mosqueServices->search($request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            $data = $this->mosqueServices->add($request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Mosque $mosque)
    {
        try {
            $data = $this->mosqueServices->show($mosque);

            return self::jsonSuccess(message: 'single mosque retrived', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Mosque $mosque)
    {
    }

    public function update(Request $request, Mosque $mosque)
    {
        try {
            $data = $this->mosqueServices->update($mosque, $request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Mosque $mosque)
    {
        try {
            $data = $this->mosqueServices->delete($mosque);

            return self::jsonSuccess(message:' mosque deleted', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
