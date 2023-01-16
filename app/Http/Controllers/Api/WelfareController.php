<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WelfareRequest;
use App\Models\Welfare;
use App\Services\WelfareServices;
use App\Traits\Jsonify;
use Exception;

class WelfareController extends Controller
{
    use Jsonify;

    private $welfareServices;

    public function __construct(WelfareServices $welfareServices)
    {
        parent::__permissions('welfares');
        $this->welfareServices = $welfareServices;
    }

    public function index(WelfareRequest $request)
    {
        try {
            $data = $this->welfareServices->search($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(WelfareRequest $request)
    {
        try {
            $data = $this->welfareServices->add($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Welfare $welfare)
    {
        try {
            $data = $this->welfareServices->show($welfare);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Welfare $welfare)
    {
    }

    public function update(WelfareRequest $request, Welfare $welfare)
    {
        try {
            $data = $this->welfareServices->update($welfare, $request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Welfare $welfare)
    {
        try {
            $data = $this->welfareServices->delete($welfare);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
