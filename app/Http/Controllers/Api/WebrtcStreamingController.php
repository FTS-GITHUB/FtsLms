<?php

namespace App\Http\Controllers\Api;

use App\Events\StreamAnswer;
use App\Events\StreamOffer;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebrtcStreamingController
{
    /**
     * Helper method to create return response
     */
    use Jsonify;

    /**
     * This returns the view for the broadcaster. We pass a 'type': broadcaster and the user's ID into the view to help identify who the user is
     *
     * @return void
     */
    public function index()
    {
        try {
            $data = ['type' => 'broadcaster', 'id' => Auth::id()];

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError(message: 'some error occurred');
        }
    }

    /**
     * It returns the view for a new user who wants to join the live stream.
     * We pass a 'type': consumer, the streamId we extract from the broadcasting link and the user's ID.
     */
    public function consumer(Request $request, $streamId)
    {
        try {
            $data = ['type' => 'consumer', 'streamId' => $streamId, 'id' => Auth::id()];

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError(message: 'some error occurred');
        }
    }

    /**
     * It broadcasts an offer signal sent by the broadcaster to a specific user who just joined.The following data is sent:
     * broadcaster: The user ID of the one who initiated the live stream i.e the broadcaster
     * receiver: The ID of the user to whom the signaling offer is being sent.
     * offer: This is the WebRTC offer from the broadcaster.
     *
     * @param  Request  $request
     * @return void
     */
    public function makeStreamOffer(Request $request)
    {
        try {
            $data['broadcaster'] = $request->broadcaster; // auth_user_id
            $data['receiver'] = $request->receiver; // user
            $data['offer'] = $request->offer;

            event(new StreamOffer($data));
        } catch (Exception $exception) {
            return self::jsonError(message: 'some error occurred');
        }
    }

    /**
     * It sends an answer signal to the broadcaster to fully establish the peer connection.
     * broadcaster: The user ID of the one who initiated the live stream i.e the broadcaster.
     * answer: This is the WebRTC answer from the viewer after, sent after receiving an offer from the broadcaster.
     */
    public function makeStreamAnswer(Request $request)
    {
        try {
            $data['broadcaster'] = $request->broadcaster;
            $data['answer'] = $request->answer;
            event(new StreamAnswer($data));
        } catch (Exception $exception) {
            return self::jsonError(message: 'some error occurred');
        }
    }
}
