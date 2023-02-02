<?php

namespace App\Http\Controllers\Api;

use App\Events\StreamAnswer;
use App\Events\StreamOffer;
use Illuminate\Http\Request;

class WebrtcStreamingController
{
    public function index()
    {
        return view('video-broadcast', ['type' => 'broadcaster', 'id' => Auth::id()]);
    }

    public function consumer(Request $request, $streamId)
    {
        return view('video-broadcast', ['type' => 'consumer', 'streamId' => $streamId, 'id' => Auth::id()]);
    }

    public function makeStreamOffer(Request $request)
    {
        $data['broadcaster'] = $request->broadcaster;
        $data['receiver'] = $request->receiver;
        $data['offer'] = $request->offer;

        event(new StreamOffer($data));
    }

    public function makeStreamAnswer(Request $request)
    {
        $data['broadcaster'] = $request->broadcaster;
        $data['answer'] = $request->answer;
        event(new StreamAnswer($data));
    }
}
