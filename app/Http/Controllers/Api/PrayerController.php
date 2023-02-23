<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrayerRequest;
use App\Models\Prayer;
use App\Services\prayerServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class PrayerController extends Controller
{
    use Jsonify;

    private $prayerServices;

    public function __construct(prayerServices $prayerServices)
    {
        parent::__permissions('prayers');
        $this->prayerServices = $prayerServices;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->prayerServices->search($request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(PrayerRequest $request)
    {
        try {
            $data = $this->prayerServices->add($request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Prayer $prayer)
    {
        try {
            $data = $this->prayerServices->show($prayer);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Prayer $prayer)
    {
    }

    public function update(Request $request, Prayer $prayer)
    {
        try {
            $data = $this->prayerServices->update($prayer, $request);

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Prayer $prayer)
    {
        try {
            $data = $this->prayerServices->delete($prayer);

            return self::jsonSuccess('record deleted', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function prayerTime(Request $request)
    {
        try {
            $data = $this->prayerServices->prayerTime($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
