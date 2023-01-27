<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buzzer;
use App\Services\BuzzerServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class BuzzerController extends Controller
{
    use Jsonify;

    private $BuzzerServices;

    public function __construct(BuzzerServices $BuzzerServices)
    {
        parent::__permissions('buzzers');
        $this->BuzzerServices = $BuzzerServices;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->BuzzerServices->search($request->all());

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
            $data = $this->BuzzerServices->create($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Buzzer $buzzer)
    {
    }

    public function edit(Buzzer $buzzer)
    {
    }

    public function update(Request $request, Buzzer $buzzer)
    {
    }

    public function destroy(Buzzer $buzzer)
    {
    }

    public function buzzers_results(Request $request)
    {
        try {
            $data = $this->BuzzerServices->buzzers_results($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
