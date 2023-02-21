<?php

namespace App\Services;

use App\Models\Event;
use App\Traits\Jsonify;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class EventServices extends BaseServices
{
    use Jsonify;

    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $model = $this->model;
            $model = $this->model->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $model);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            // $start = Carbon::createFromFormat('Y-m-d', $request->start);
            // $end = Carbon::createFromFormat('Y-m-d', $request->end);
            // dd($start, $end);

            $data = Event::create([
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
            ]);

            DB::commit();

            return self::jsonSuccess(message: 'Event saved successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    // public function show($book)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $data = Book::with('category')->find($book);
    //         DB::commit();

    //         return self::jsonSuccess(data: $data);
    //     } catch (Exception $exception) {
    //         DB::rollback();

    //         return self::jsonError($exception->getMessage());
    //     }
    // }

    // update events

    public function update($event, $request)
    {
        DB::beginTransaction();
        try {
            $data = $event->update([
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
            ]);

            DB::commit();

            return self::jsonSuccess(message: 'Event updated successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    // event delete

    public function delete($event)
    {
        DB::beginTransaction();
        try {
            $data = $event->delete();
            DB::commit();

            return self::jsonSuccess(message: 'Book deleted successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
