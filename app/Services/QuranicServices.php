<?php

namespace App\Services;

use App\Models\Quranic;
use App\Models\Tag;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuranicServices extends BaseServices
{
    use Jsonify;

    public function __construct(Quranic $model)
    {
        parent::__construct($model);
    }

    public function search($params = [])
    {
        DB::beginTransaction();
        try {
            $data = $this->model->paginate(10);
            DB::commit();

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function add($request)
    {
        DB::beginTransaction();
        try {
            $data = Quranic::create([
                'qari_name' => $request['qari_name'],
                'surah_name' => $request['surah_name'],
                'para_number' => $request['para_number'],
            ]);
            $file = $request->file('audio')->store('audio');
            $data = Tag::create([
                'url' => $file,
                'tagable_id' => $data->id,
                'tag_name' => $request['tag_name'],
                'tagable_type' => \App\Models\Quranic::class,
            ]);
            DB::commit();

            return self::jsonSuccess(message: 'Quranic Data saved successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function update($quranic, $request)
    {
        DB::beginTransaction();
        try {
            $data = $quranic->update($request->all());
            DB::commit();

            return self::jsonSuccess(message: 'Quranic data updated successfully!', data: $data);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }

    public function delete($quranic)
    {
        DB::beginTransaction();
        try {
            $quranic->delete();
            $file = Tag::where('id', $quranic->id)->first();
            if ($quranic->delete()) {
                if ($file->delete()) {
                    Storage::delete([
                        $file->url,
                    ]);
                }
            }

            DB::commit();

            return self::jsonSuccess(message: 'Quranic data deleted successfully!', data: $quranic);
        } catch (Exception $exception) {
            DB::rollback();

            return self::jsonError($exception->getMessage());
        }
    }
}
