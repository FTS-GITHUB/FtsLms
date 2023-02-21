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

    /**
     * load permissions and services
     *
     * @param  RoundServices  $roundServices
     */
    public function __construct(RoundServices $roundServices)
    {
        parent::__permissions('rounds');
        $this->roundServices = $roundServices;
    }

    /**
     * getting all round data from database
     *
     * @param  RoundRequest  $request
     * @return void
     */
    public function index(RoundRequest $request)
    {
        try {
            $data = $this->roundServices->search($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
    }

    /**
     * add new record to database
     *
     * @param  RoundRequest  $request
     * @return void
     */
    public function store(RoundRequest $request)
    {
        try {
            $data = $this->roundServices->create($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * show single record from database
     *
     * @param  Round  $round
     * @return void
     */
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

    /**
     * update a round record
     *
     * @param  RoundRequest  $request
     * @param  Round  $round
     * @return void
     */
    public function update(RoundRequest $request, Round $round)
    {
        try {
            $data = $this->roundServices->update($round, $request);

            return self::jsonSuccess(data:$data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * delete round record
     *
     * @param  Round  $round
     * @return void
     */
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
