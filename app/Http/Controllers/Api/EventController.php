<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Services\EventServices;
use App\Traits\Jsonify;
use Exception;

class EventController extends Controller
{
    use Jsonify;

    private $eventService;

    /**
     * load permissions and eventServices
     *
     * @param  EventServices  $eventService
     */
    public function __construct(EventServices $eventService)
    {
        parent::__permissions('events');
        $this->eventService = $eventService;
    }

    /**
     * getting the event service
     *
     * @param  EventRequest  $request
     * @return void
     */
    public function index(EventRequest $request)
    {
        $data = Event::whereDate('start', '>=', $request->start)
                        ->whereDate('end', '<=', $request->end)
                        ->get(['id', 'title', 'start', 'end']);

        return response()->json($data);
    }

    public function create()
    {
    }

    /**
     * add a new event
     *
     * @param  EventRequest  $request
     * @return void
     */
    public function store(EventRequest $request)
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

    /**
     * update event
     *
     * @param  EventRequest  $request
     * @param  Event  $event
     * @return void
     */
    public function update(EventRequest $request, Event $event)
    {
        try {
            $data = $this->eventService->update($event, $request);

            return self::jsonSuccess(message: 'Data saved successfully!', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * delete event
     *
     * @param  Event  $event
     * @return void
     */
    public function destroy(Event $event)
    {
        try {
            $event = $event->delete();

            return self::jsonSuccess(message: 'Data deleted successfully!', data: $event);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
