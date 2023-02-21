<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuranicRequest;
use App\Models\Quranic;
use App\Services\QuranicServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class QuranicController extends Controller
{
    use Jsonify;

    private $quranicService;

    /**
     * load services when constructor called
     *
     * @param  QuranicServices  $quranicService
     */
    public function __construct(QuranicServices $quranicService)
    {
        parent::__permissions('quranics');
        $this->quranicService = $quranicService;
    }

    /**
     * getting all data from database
     *
     * @param  Request  $request
     * @return void
     */
    public function index(Request $request)
    {
        try {
            $data = $this->quranicService->search($request->all());

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
     * create new quranic record
     *
     * @param  QuranicRequest  $request
     * @return void
     */
    public function store(QuranicRequest $request)
    {
        try {
            $data = $this->quranicService->add($request);

            return self::jsonSuccess(message: 'Data saved successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * show single data
     *
     * @param  Quranic  $quranic
     * @return void
     */
    public function show(Quranic $quranic)
    {
        try {
            return self::jsonSuccess(message: 'Quranic data saved successfully!', data: $quranic->with('tags')->first());
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Quranic $quranic)
    {
    }

    /**
     * update quranic record
     *
     * @param  QuranicRequest  $request
     * @param  Quranic  $quranic
     * @return void
     */
    public function update(QuranicRequest $request, Quranic $quranic)
    {
        try {
            dd($request->all(), $quranic);
            $data = $this->quranicService->update($quranic, $request);

            return self::jsonSuccess(message: 'Data update successfully!', data:$data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * delete quranic records
     *
     * @param  Quranic  $quranic
     * @return void
     */
    public function destroy(Quranic $quranic)
    {
        try {
            $data = $this->quranicService->delete($quranic);

            return self::jsonSuccess(message: 'Data destroy successfully!', data:$data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
