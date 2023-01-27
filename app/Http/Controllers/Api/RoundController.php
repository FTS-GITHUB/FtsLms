<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoundRequest;
use App\Models\Round;
use App\Services\RoundServices;
use App\Traits\Jsonify;
use Exception;

class RoundController extends Controller
{
    use Jsonify;

    private $roundServices;

    public function __construct(RoundServices $roundServices)
    {
        parent::__permissions('rounds');
        $this->roundServices = $roundServices;
    }

    public function index(RoundRequest $request)
    {
        try {
            $data = $this->roundServices->search($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(RoundRequest $request)
    {
        try {
            $data = $this->roundServices->create($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Round $round)
    {
        try {
            $data = $this->roundServices->show($round);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Round $round)
    {
    }

    public function update(RoundRequest $request, Round $round)
    {
        try {
            $data = $this->roundServices->update($round, $request);

            return self::jsonSuccess(data:$data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Round $round)
    {
        try {
            $data = $this->roundServices->delete($round);

            return self::jsonSuccess($data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
