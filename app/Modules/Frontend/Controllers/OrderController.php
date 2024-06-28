<?php

/**
 * Created by PhpStorm.
 * User: JreamOQ ( jreamoq@gmail.com )
 * Date: 12/21/20
 * Time: 13:00
 */

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendUserJob;
use App\Repositories\OrderRepository;
use App\Repositories\PropertyAvailabilityRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\RoleUserRepository;
use App\Repositories\UserRepository;
use App\Services\OrderService;
use Google\Service\ShoppingContent\OrderReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use TorMorten\Eventy\Facades\Eventy;
use Unicodeveloper\Paystack\Facades\Paystack;

class OrderController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = OrderService::inst();
    }

    public function paymentChecking(Request $request)
    {
        $order_token = $request->get('order_token');
        $status = $request->get('status');

        $response = $this->service->paymentChecking($order_token, $status);

        if ($response && ($response['payment_status'] == 1)) {
            return redirect(route('complete-order') . "?" . http_build_query(['order_token' => $order_token]));
        } else {
            info('we checking out');
            return redirect(url('checkout'))->with([
                'message' => $response['message'],
                'order_token' => $order_token,
                'payment_failed' => 1,
            ]);
        }
    }

    public function completeOrder(Request $request)
    {
        $response = $this->service->completeOrderChecking($request);
        $view = apply_filter('gmz_complete_order_view', 'Frontend::page.complete-order', $response);
        return view($view, $response);
    }

    public function checkoutAction(Request $request)
    {
        $post_data = $request->all();
        info('post_data');

        $payment = $post_data['payment_method'];
        if ($payment == 'paystack') {
            $cart = \Cart::inst()->getCart();
            if (!empty($cart)) {
                $actionRespon = apply_filter('gmz_before_do_checkout', [], $cart);
                if (!empty($actionRespon)) {
                    return $actionRespon;
                }
                $post_type = $cart['post_type'];
                $serviceRepo = '\\App\\Repositories\\' . ucfirst($post_type) . 'Repository';
                $serviceObject = $serviceRepo::inst()->find($cart['post_id']);
                if ($serviceObject) {
                    $cart_data = $cart['cart_data'];
                    $checkingBefore = $this->service->checkingBeforeCheckout($serviceObject, $cart);
                    if (!empty($checkingBefore)) {
                        return $checkingBefore;
                    }


                    $property_availability =  PropertyAvailabilityRepository::inst();
                    $check_avail = $property_availability::inst()->checkAvailability($cart['post_id']);
                    if (!$check_avail) {
                        return [
                            'status' => false,
                            'message' => __('This service is not available')
                        ];
                    }


                    //Validate form checkout
                    $valid = Validator::make($request->all(), [
                        'first_name' => ['required'],
                        'email' => ['required', 'email'],
                        'phone' => ['required'],
                        'address' => ['required'],
                    ]);

                    if ($valid->fails()) {
                        return [
                            'status' => 0,
                            'message' => $valid->errors()->first()
                        ];
                    }

                    $post_data = $request->all();

                    $agree = $request->post('agree', '');
                    if ($agree != 1) {
                        return [
                            'status' => 0,
                            'message' => __('Please agree with our Terms and Conditions')
                        ];
                    }

                    if (!is_user_login()) {
                        $userRepo = UserRepository::inst();
                        $user_exists = $userRepo->where(['email' => $post_data['email']], true);
                        if (!empty($user_exists)) {
                            return [
                                'status' => false,
                                'message' => __('Your email already exists. Please login with that email or use another email')
                            ];
                        }

                        $user_password = random_user_password(8);
                        $user_data = [
                            'first_name' => $post_data['first_name'],
                            'last_name' => $post_data['last_name'],
                            'email' => $post_data['email'],
                            'password' => Hash::make($user_password),
                            'password_origin' => $user_password,
                            'address' => $post_data['address']
                        ];

                        $user_id = $userRepo->create($user_data);

                        if ($user_id) {
                            $roleUserRepo = RoleUserRepository::inst();
                            $roleUserRepo->create([
                                'role_id' => 3,
                                'user_id' => $user_id,
                            ]);
                            $user_data['user_id'] = $user_id;

                            Auth::attempt([
                                'email' => $post_data['email'],
                                'password' => $user_password
                            ], true);

                            dispatch(new SendUserJob($user_data));
                        } else {
                            return [
                                'status' => false,
                                'message' => __('Have an error when creating new user. Please try again.')
                            ];
                        }
                    } else {
                        $user_id = get_current_user_id();
                    }

                    $payment = $post_data['payment_method'];
                    if (empty($payment)) {
                        $payment = 'bank_transfer';
                    }




                    $checkout_data = $cart;
                    unset($checkout_data['post_object']);

                    $token_code = ($payment == 'stripe') ? $post_data['stripeToken'] : '';
                    $commission = (get_option('commission')) ? get_option('commission') : 0;
                    $customer_email = $post_data['email'];




                    $order_data = Eventy::filter('gmz_checkout_data', array(
                        'sku' => uniqid(),
                        'post_id' => $cart['post_id'],
                        'total' => $cart['total'],
                        'number' => isset($cart_data['number']) ? $cart_data['number'] : 1,
                        'buyer' => $user_id,
                        'owner' => $serviceObject['author'],
                        'payment_type' => $payment,
                        'checkout_data' => json_encode($checkout_data),
                        'token_code' => $token_code,
                        'currency' => json_encode(current_currency()),

                        'post_type' => $post_type,
                        'payment_status' => GMZ_PAYMENT_PENDING,
                        'status' => GMZ_STATUS_INCOMPLETE,
                        'first_name' => $post_data['first_name'],
                        'last_name' => $post_data['last_name'],
                        'email' => $customer_email,
                        'phone' => $post_data['phone'],
                        'address' => $post_data['address'],
                        'city' => $post_data['city'],
                        'country' => $post_data['country'],
                        'postcode' => $post_data['postcode'],
                        'note' => $post_data['note'],
                        'commission' => $commission
                    ), $cart);



                    //Check add new or update order
                    $order_token = $request->post('order_token');
                    if (!empty($order_token)) {
                        $property_repo = PropertyRepository::inst();
                        $order_require_updates = $property_repo->findOneBy(['order_token' => $order_token]);
                        if (!empty($order_require_updates) && ($order_require_updates['payment_status'] == 0)) {
                            $property_repo->updateByWhere(['order_token' => $order_token], [
                                'first_name' => $post_data['first_name'],
                                'last_name' => $post_data['last_name'],
                                'email' => $post_data['email'],
                                'phone' => $post_data['phone'],
                                'address' => $post_data['address'],
                                'city' => $post_data['city'],
                                'country' => $post_data['country'],
                                'postcode' => $post_data['postcode'],
                                'note' => $post_data['note'],
                                'payment_type' => $payment,
                                'payment_status' => GMZ_PAYMENT_PENDING,
                            ]);
                            $property_repo->appendChangeLog($order_require_updates['id'], 'system', 're-order');
                            $re_order = true;
                            $order_id = $order_require_updates['id'];
                        }
                    }

                    if (empty($re_order)) {
                        $property_repo = OrderRepository::inst();
                        $order_id =  $property_repo->create($order_data);

                        $property_repo->updateByWhere(['id' => $order_id], [
                            'order_token' => gmz_hashing($order_id),
                            'sku' => 668 + $order_id,
                        ]);
                    }


                    info('paystack');
                    $model = new \App\Models\Order();
                    $order = $model->query()->findOrFail($order_id);

                    $paymentDetails = [
                        'email' => $post_data['email'], // User's email for Paystack
                        'first_name' => $post_data['first_name'],
                        'last_name' => $post_data['last_name'],
                        'amount' => $order->total * 100, // Amount in kobo
                        'reference' => Paystack::genTranxRef(), // Generate a unique reference
                        "callback_url" => env('PAYSTACK_CALLBACK_URL'),
                        'currency' => 'GHS',
                        'metadata' => [
                            'user_id' => $order->buyer,
                            'order_id' => $order->id,
                        ],
                    ];

                    // Assuming you have fetched the order details successfully
                    // Generate a unique transaction ID (You can use any unique identifier method here)
                    $transactionId = uniqid(); // Example: Generating a unique ID using uniqid()

                    $order->transaction_id = $transactionId;
                    $order->save();
                    // info('transaction', $order->transaction_id);
                    // Initialize the payment with payment details and get the authorization URL using the helper function
                    $paymentLink = Paystack::getAuthorizationUrl($paymentDetails)->redirectNow();
                    
                    // Prepare the response data including the payment link (redirect URL)
                    $response = [
                        'redirect' => $paymentLink->getTargetUrl(),
                        // Include any other necessary data
                    ];
                    info('response is', $response);

                    // Return the response as JSON using Laravel's response() method
                    return response()->json($response);




                    // $after_payment = $after->doPaymentCheckout($order_id, $customer_email);

                }
            } else {
                $status =  [
                    'status' => false,
                    'message' => __('The order is invalid')
                ];

                return response()->json($status);
            }
        } else {
            $response = $this->service->checkOut($request);
            return response()->json($response);
        }
    }




    public function checkoutView()
    {
        $order_data = NULL;

        if (session()->has('payment_failed') && (session('payment_failed') == 1)) {

            $order_token = \session('order_token');
            $order_data = $this->service->unsuccessfulPaymentProcessing($order_token);
        }
        $cart = \Cart::inst()->getCart();

        return view('Frontend::page.checkout')->with('order_data', $order_data);
    }
}
