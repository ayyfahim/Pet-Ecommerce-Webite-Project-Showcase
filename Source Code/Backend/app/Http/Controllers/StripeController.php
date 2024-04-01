<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

/**
 * @group Stripe
 */
class StripeController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Create Stripe Payment Intent
     * @queryParam total
     * @param Request $request
     * @return JsonResponse
     */
    public function createPaymentIntent(Request $request)
    {

        if ($request->has('total')) {
            try {
                $stripe = new \Stripe\StripeClient(
                    env('STRIPE_SECRET')
                );
                $result = $stripe->paymentIntents->create(
                    [
                        'amount' => $request->total * 100,
                        'payment_method_types' => ['card', 'afterpay_clearpay'],
                        'currency' => 'usd'
                    ]
                );
                return response()->json(['client_secret' => $result->client_secret]);
            } catch (\Stripe\Exception\CardException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getError()->message
                ]);
            } catch (\Stripe\Exception\RateLimitException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getError()->message
                ]);
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getError()->message
                ]);
            } catch (\Stripe\Exception\AuthenticationException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getError()->message
                ]);
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getError()->message
                ]);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getError()->message
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getError()->message
                ]);
            }
        }
    }

    public function webhook()
    {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET', 'whsec_eX9f0SkelmdEsmep2gbxEgBwYW8Yx5S7');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET', 'sk_test_51GuuiiCB2udiApBimTAbIM8MkV7QfR3h6TWHHkFb3duVVHCz7PVGxDtfIJG3Yf8Ky9EUCo6fqC9n4Wr1CrdekSlW009TU9VAey'));
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            echo $e->getMessage();
            return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $payment_intent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

                $order = Order::where('session_id', $session->id)->first();
                // if ($order && $order->status === 'unpaid') {
                //     $order->status = 'paid';
                //     $order->save();
                //     // Send email to customer
                // }

                $status = Order::getStatusFor('status');
                $status_id = $status->firstWhere('order', 1)->id;

                if ($order && $order->status->id === $status_id) {

                    $status = Order::getStatusFor('payment_method');
                    $status_id = $status->firstWhere('order', 1)->id;

                    $order->update([
                        'payment_id' => $payment_intent->client_secret,
                        'payment_method_id' => $status_id,

                        'payment_info' =>  $payment_intent->charges->data[0]->toArray(),
                        'is_temp' => false
                    ]);
                }
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('');
    }
}
