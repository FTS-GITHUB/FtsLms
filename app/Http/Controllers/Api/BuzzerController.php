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
    /**
     * Helper method to create response
     */
    use Jsonify;

    /**
     * global variables for services
     */
    private $BuzzerServices;

    /**
     * load services when constructor is called
     *
     * @param  BuzzerServices  $BuzzerServices
     */
    public function __construct(BuzzerServices $BuzzerServices)
    {
        parent::__permissions('buzzers');
        $this->BuzzerServices = $BuzzerServices;
    }

    /**
     * getting all questions
     *
     * @param  Request  $request
     * @return void
     */
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

    /**
     * create question in database
     *
     * @param  Request  $request
     * @return void
     */
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

    /**
     * buzzer results are return
     *
     * @param  Request  $request
     * @return void
     */
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
