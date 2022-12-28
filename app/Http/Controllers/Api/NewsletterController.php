<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    use Jsonify;

    public function __construct()
    {
        parent::__permissions('newsletter');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $newsletter = Newsletter::where('status', 'true')->get();

            return self::jsonSuccess(data:$newsletter, message: 'Subscription Retrived successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);
            $newsletter = Newsletter::create([
                'email' => $request->email,
                'status' => true,
            ]);
            $subscription = [
                'email' => $newsletter->email,
            ];
            Mail::send('emails.subscription', $subscription, function ($message) use ($subscription) {
                $message->from('no_reply@firm-tech.com', 'newsletters Request');
                $message->to($subscription['email'], 'firm-tech.com');
                $message->subject('Subscribe our news (lms system)');
            });
            if (Mail::flushMacros()) {
                return response()->json([
                    'message' => 'Some error occured , Please Try again',
                    'status_code' => 500,
                ], 500);
            }

            return self::jsonSuccess(data:$newsletter, message: 'subscription successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsletter $newsletter)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $newsletter)
    {
        //
    }

    public function un_subscribe(Request $request)
    {
        try {
            $subscription = Newsletter::where('email', $request->email)->first();
            if ($subscription) {
                $subscription->status = 'false';
                $subscription->save();
            }

            return self::jsonSuccess(data:$subscription, message: 'Un-subscription  successfully.');
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
