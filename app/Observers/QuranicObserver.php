<?php

namespace App\Observers;

use App\Models\Quranic;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class QuranicObserver
{
    /**
     * Handle the Quranic "created" event.
     *
     * @param  \App\Models\Quranic  $quranic
     * @return void
     */
    public function created(Quranic $quranic)
    {
        //
    }

    /**
     * Handle the Quranic "updated" event.
     *
     * @param  \App\Models\Quranic  $quranic
     * @return void
     */
    public function updated(Quranic $quranic)
    {
        //
    }

    /**
     * Handle the Quranic "deleted" event.
     *
     * @param  \App\Models\Quranic  $quranic
     * @return void
     */
    public function deleted(Quranic $quranic)
    {
        $file = Tag::where('id', $quranic->id)->first();

        if ($quranic->delete()) {
            if ($file->delete()) {
                Storage::delete([
                    $file->url,
                ]);
            }
        }
    }

    /**
     * Handle the Quranic "restored" event.
     *
     * @param  \App\Models\Quranic  $quranic
     * @return void
     */
    public function restored(Quranic $quranic)
    {
        //
    }

    /**
     * Handle the Quranic "force deleted" event.
     *
     * @param  \App\Models\Quranic  $quranic
     * @return void
     */
    public function forceDeleted(Quranic $quranic)
    {
        //
    }
}
