<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Jsonify;
use Illuminate\Http\Request;
use Stripe;

class StripePaymentController extends Controller
{
    use Jsonify;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        // Stripe\stripe::setApiKey(env('STRIPE_SECRET'));

        // $customer = Stripe\Customer::create([

        //     'address' => [

        //         'line1' => 'Virani Chowk',

        //         'postal_code' => '360001',

        //         'city' => 'Rajkot',

        //         'state' => 'GJ',

        //         'country' => 'IN',

        //     ],

        //     'email' => 'demo@gmail.com',

        //     'name' => 'Hardik Savani',

        //     'source' => $request->stripeToken,

        // ]);

        // Stripe\Charge::create([

        //     'amount' => 100 * 100,

        //     'currency' => 'usd',

        //     'customer' => $customer->id,

        //     'description' => 'Test payment from itsolutionstuff.com.',

        //     'shipping' => [

        //         'name' => 'Jenny Rosen',

        //         'address' => [

        //             'line1' => '510 Townsend St',

        //             'postal_code' => '98140',

        //             'city' => 'San Francisco',

        //             'state' => 'CA',

        //             'country' => 'US',

        //         ],

        //     ],

        // ]);

        return self::jsonSuccess(message: 'Role updated successfully.');
    }
}
