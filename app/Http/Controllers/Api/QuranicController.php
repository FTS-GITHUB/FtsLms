<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuranicRequest;
use App\Models\Quranic;
use App\Services\QuranicServices;
use App\Traits\Jsonify;
use Exception;

class QuranicController extends Controller
{
    use Jsonify;

    private $quranicService;

    public function __construct(QuranicServices $quranicService)
    {
        parent::__permissions('quranics');
        $this->quranicService = $quranicService;
    }

    public function index(QuranicRequest $request)
    {
        try {
            $data = $this->quranicService->search($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(QuranicRequest $request)
    {
        try {
            $data = $this->quranicService->add($request);

            return self::jsonSuccess(message: 'Data saved successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Quranic $quranic)
    {
        try {
            return self::jsonSuccess(message: 'Quranic data saved successfully!', data: $quranic);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Quranic $quranic)
    {
    }

    public function update(QuranicRequest $request, Quranic $quranic)
    {
        try {
            $data = $this->quranicService->update($quranic, $request);

            return self::jsonSuccess(message: 'Data update successfully!', data:$data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

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
