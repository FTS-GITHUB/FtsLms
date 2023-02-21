<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marquee;
use App\Services\MarqueeServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class MarqueeController extends Controller
{
    use Jsonify;

    private $MarqueeServices;

    public function __construct(MarqueeServices $MarqueeServices)
    {
        parent::__permissions('marquees');
        $this->MarqueeServices = $MarqueeServices;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->MarqueeServices->search($request);

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return self::jsonSuccess(message: '', data: '');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Marquee $marquee)
    {
        try {
            return self::jsonSuccess(message: '', data: '');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Marquee $marquee)
    {
    }

    public function update(Request $request, Marquee $marquee)
    {
        try {
            $data = $this->MarqueeServices->update($marquee, $request);

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Marquee $marquee)
    {
        try {
            return self::jsonSuccess(message: '', data: '');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function approved($id)
    {
        try {
            $data = $this->MarqueeServices->approved($id);

            return self::jsonSuccess(message: 'Header approved successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
