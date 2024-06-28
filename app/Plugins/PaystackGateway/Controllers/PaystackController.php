<?php


namespace App\Plugins\PaystackGateway\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackController extends Controller
{
    protected $id = 'paystack';
  

    public function getName()
    {
        return __('Paystack');
    }

    public function getHtml()
    {
        return view('Plugin.PaystackGateway::index', ['id' => $this->id]);
    }

    public function doPaymentCheckout($order_id, $customer_email)
    {
        $model = new \App\Models\Order();
        $order = $model->query()->findOrFail($order_id);


        // Assuming you have fetched the order details successfully
         // Generate a unique transaction ID (You can use any unique identifier method here)
        $transactionId = uniqid(); // Example: Generating a unique ID using uniqid()

        try {

            $order->transaction_id = $transactionId;
            $order->save();
            // Initialize the payment with payment details and get the authorization URL using the helper function
            $paymentLink = paystack()->getAuthorizationUrl($this->preparePaymentDetails($order, $customer_email))->redirectNow();

            // Redirect the user to the Paystack payment page
            return $paymentLink;
        } catch (\Exception $e) {
            // Handle any exceptions that might occur during payment initialization
            return back()->withError('Payment initialization failed: ' . $e->getMessage());
        }
    }

    private function preparePaymentDetails($order, $customer_email)
    {
        info($order);
        return [
            'amount' => $order->amount * 100, // Paystack requires amount in kobo (multiply by 100 for naira)
            'email' => $customer_email,
            'currency' => 'GHS',
            'reference' => Paystack::genTranxRef(), // Replace with a unique reference for the transaction
            'metadata' => [
                'order_id' => $order->id,

                // Other metadata associated with the order
            ],
        ];
    }

    // private function convertToKobo($amount, $currency)
    // {
    //     $currencyMultipliers = [
    //         'GHS' => 100,  // 1 GHS = 100 kobo
    //         'USD' => 100 * 100,  // 1 USD = 100 cents = 10000 kobo
    //         // Add more currencies and their multipliers as needed
    //         // 'EUR' => 100 * 100, // Example for Euro
    //     ];

    //     // Default multiplier if the currency is not found
    //     $defaultMultiplier = 1; // Assume default currency is in kobo already

    //     // Check if the currency exists in the multipliers array
    //     if (array_key_exists($currency, $currencyMultipliers)) {
    //         // Convert amount to kobo based on the currency multiplier
    //         return $amount * $currencyMultipliers[$currency];
    //     }

    //     // If the currency is not found, assume the amount is already in kobo
    //     return $amount * $defaultMultiplier;
    // }

    public function handlePaystackWebhook(Request $request)
    {
        // Retrieve the payload from the incoming request
        $payload = $request->all();
        info($payload);
    
        // Verify the authenticity of the webhook request
        // Verify Paystack signature here
    
        // Process the webhook payload based on the event type
        $event = $payload['event'] ?? null; // Retrieve the event type from the payload
    
        if ($event === 'charge.success') {
            // Payment was successful
            // Get the transaction reference
            $transactionReference = $payload['data']['reference'] ?? null;
            $orderModel = new \App\Models\Order();
			$order      = $orderModel->query()->find( $order_id );
    
            if ($transactionReference) {
                // Retrieve payment data using Paystack SDK
                $paymentData = Paystack::getPaymentData($transactionReference);
    
                // Process payment data as needed
                // For example, log payment details, update your database, etc.
    
                // Assuming $response contains the data to be returned in the webhook response
                $response = [];
    
                if (!empty($paymentData['payment_status']) && isset($paymentData['transaction_id'])) {
                    // Existing logic for successful payment handling
                    
                    // ... (existing logic)
    
                    // Update payment status of the order
                    $order_id = $paymentData['order_id']; // Assuming order_id is available in payment data
                    $orderModel->query()
                               ->where('id', $order_id)
                               ->update([
                                   'payment_status' => GMZ_PAYMENT_COMPLETED,
                                   'status' => GMZ_STATUS_COMPLETE,
                                   'transaction_id' => $paymentData['transaction_id']
                               ]);
                    $orderModel->appendChangeLog($order_id, 'system', 'payment success');
    
                    add_money_to_wallet($order_id);
    
                    // Get the redirect link for further processing
                    $response['redirect'] = $this->getLinkPaymentChecking($order_id);
                }
    
                // Return the response
                return $response;
            }
        } elseif ($event === 'charge.failed') {
            // Payment failed
            // Handle the failed payment event, log, or take appropriate action
    
            // Assuming $response contains the data to be returned in the webhook response for failed payment event
            return $response; // Ensure $response is defined or handle the failed event accordingly
        } else {
            // Other events - handle them accordingly
    
            // Assuming $response contains the data to be returned in the webhook response for other events
            return $response; // Ensure $response is defined or handle other events accordingly
        }
    
        // Return a response (Paystack expects a 200 response)
        return response()->json(['status' => 'success']);
    }
    

     /**
     * Get all customers that have performed transactions on your platform with Paystack
     *
     * @return array|null
     */
    public function getAllCustomers()
    {
        try {
            // Retrieve all customers using Paystack SDK/API
            $customers = Paystack::getAllCustomers();
            
            // Return the array of customers
            return $customers;
           // return view('customers')->with('customers', $customers);
        //}
        } catch (\Exception $e) {
            // Handle exceptions if any
            // You can log the error or return null/error message as needed
            return null;
        }
    }

    /**
     * Get all transactions performed on your platform with Paystack
     *
     * @return array|null
     */
    public function getAllTransactions()
    {
        try {
            // Retrieve all transactions using Paystack SDK/API
            $transactions = Paystack::getAllTransactions();
            
            // Return the array of transactions
            return $transactions;
           // return view('transactions')->with('transactions', $transactions)
        } catch (\Exception $e) {
            // Handle exceptions if any
            // You can log the error or return null/error message as needed
            return null;
        }
    }


    public function settingFields()
    {
        return [
            [
                'id' => 'payment_paystack_enable',
                'label' => __('Enable'),
                'type' => 'switcher',
                'layout' => 'col-12',
                'std' => 'on',
                'break' => true,
                'tab' => 'paystack',
            ],
            [
                'id' => 'payment_paystack_name',
                'label' => __('Name'),
                'type' => 'text',
                'layout' => 'col-12',
                'std' => 'Paystack',
                'break' => true,
                'translation' => true,
                'tab' => 'paystack',
                'condition' => 'payment_paystack_enable:on'
            ],
            [
                'id' => 'payment_paystack_desc',
                'label' => __('Description'),
                'type' => 'textarea',
                'layout' => 'col-12',
                'std' => '',
                'break' => true,
                'translation' => true,
                'tab' => 'paystack',
                'condition' => 'payment_paystack_enable:on'
            ],
            [
                'id' => 'payment_paystack_logo',
                'label' => __('Logo'),
                'type' => 'image',
                'layout' => 'col-12 col-md-6',
                'std' => '',
                'break' => true,
                'tab' => 'paystack',
                'condition' => 'payment_paystack_enable:on'
            ],
            [
                'id' => 'payment_paystack_sandbox',
                'label' => __('Is Sandbox'),
                'type' => 'switcher',
                'layout' => 'col-12',
                'std' => 'on',
                'break' => true,
                'tab' => 'paystack',
                'condition' => 'payment_paystack_enable:on'
            ],
            // [
            //     'id' => 'payment_paystack_pos_id',
            //     'label' => __('Pos ID'),
            //     'type' => 'text',
            //     'layout' => 'col-12 col-md-6',
            //     'std' => '',
            //     'tab' => 'paystack',
            //     'condition' => 'payment_paystack_enable:on'
            // ],
            [
                'id' => 'payment_paystack_public_key',
                'label' => __('Public Key'),
                'type' => 'text',
                'layout' => 'col-12 col-md-6',
                'std' => '',
                'tab' => 'paystack',
                'condition' => 'payment_paystack_enable:on'
            ],
            [
                'id' => 'payment_paystack_client_secret',
                'label' => __('Client Secret'),
                'type' => 'text',
                'layout' => 'col-12 col-md-6',
                'std' => '',
                'break' => true,
                'tab' => 'paystack',
                'condition' => 'payment_paystack_enable:on'
            ],
        ];
    }
}
