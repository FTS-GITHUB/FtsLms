<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WelfareRequest;
use App\Models\Welfare;
use App\Services\WelfareServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class WelfareController extends Controller
{
    use Jsonify;

    private $welfareServices;

    public function __construct(WelfareServices $welfareServices)
    {
        parent::__permissions('welfares');
        $this->welfareServices = $welfareServices;
    }

    /**
     * getting welfares data from database
     *
     * @param  Request  $request
     * @return void
     */
    public function index(Request $request)
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

    /**
     * create a new welfare data
     *
     * @param  WelfareRequest  $request
     * @return void
     */
    public function store(WelfareRequest $request)
    {
        try {
            $data = $this->welfareServices->add($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * display single welfare record from database
     *
     * @param  Welfare  $welfare
     * @return void
     */
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

    /**
     * update single record from database
     *
     * @param  WelfareRequest  $request
     * @param  Welfare  $welfare
     * @return void
     */
    public function update(WelfareRequest $request, Welfare $welfare)
    {
        try {
            $data = $this->welfareServices->update($welfare, $request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * delete record from database
     *
     * @param  Welfare  $welfare
     * @return void
     */
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
