<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 2/23/2020
 * Time: 5:01 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\Order\Creation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;

/**
 * @group PaymentHandler
 */
class PaymentHandler extends Controller
{
    use Creation;

    public function __construct()
    {
        $this->middleware('auth')->except(['callbackSuccess','redirect_mobile']);
    }

    public
    function callbackSuccess(Request $request)
    {
        try {

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
        } catch (ApiErrorException $e) {
            return false;
        }
//        dd($session->client_reference_id);
        $log = "========================================================\n\n" . print_r($request->input(), 1) . "\n\n";
        Log::channel('payment')->info($log);
        if ($session->client_reference_id) {
            $order_id = explode('_', $session->client_reference_id)[0];
            $order = Order::where('id', $order_id)->where('is_temp', true)->firstOrFail();
            $data['payment_info'] = $request->input();
            $response['success'] = $session->payment_status == 'paid';
            if ($response['success']) {
                $data['is_temp'] = false;
                $order->update($data);
                $response = array_merge($response, $this->successResponse($order));
                $response['message'] = "Order Placed Successfully";
            } else {
                $response['message'] = "Payment Failed";
            }
            return redirect()->route('paymentHandler.redirect', $response);
        } else {
            abort(404);
        }
    }
    public function redirect(Request $request){
        dd($request->input());
    }
    public function redirect_mobile(Request $request){
//        dd($request->input());
    }
}
