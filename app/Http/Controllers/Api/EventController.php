<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\EventServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use Jsonify;

    private $eventService;

    public function __construct(EventServices $eventService)
    {
        parent::__permissions('events');
        $this->eventService = $eventService;
    }

    // show event by date
    public function index(Request $request)
    {
        $data = Event::whereDate('start', '>=', $request->start)
                        ->whereDate('end', '<=', $request->end)
                        ->get(['id', 'title', 'start', 'end']);

        return response()->json($data);
    }

    public function create()
    {
    }

    // add event

    public function store(Request $request)
    {
        try {
            $data = $this->eventService->create($request);

            return self::jsonSuccess(message: 'Data saved successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(Event $event)
    {
    }

    public function edit(Event $event)
    {
    }

    public function update(Request $request, Event $event)
    {
        try {
            $data = $this->eventService->update($event, $request);

            return self::jsonSuccess(message: 'Data saved successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(Event $event)
    {
        $event = $event->delete();

        return response()->json($event);
    }
}
