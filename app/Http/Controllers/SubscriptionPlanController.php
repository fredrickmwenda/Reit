<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PlanPrice;
use App\Models\TempSubscription;
use Illuminate\Http\Request;
use Unicodeveloper\Paystack\Facades\Paystack;
use LucasDotVin\Soulbscription\Models\Plan;

class SubscriptionPlanController extends Controller
{
    // public function index(){
    //     $subscriptionPlans = SubscriptionPlan::paginate(10);
    //     return view('subscription.index', compact('subscriptionPlans'));
    // }
    // public function create()
    // {
    //     return view('subscription.create');
    // }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'description' => 'required',
    //         'duration_unit' => 'required|in:days,weeks,months,years',
    //         'duration' => 'required|integer',
    //         'price' => 'required|numeric|min:0',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     SubscriptionPlan::create($request->all());

    //     return redirect()->route('subscription.index')->with('success', 'Subscription plan created successfully!');
    // }

    // public function edit($id)
    // {
    //     $subscriptionPlan  = SubscriptionPlan::findOrFail($id);
    //     return view('subscription.edit', compact(' subscriptionPlan '));
    // }

    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'description' => 'required',
    //         'duration_unit' => 'required|in:days,weeks,months,years',
    //         'duration' => 'required|integer',
    //         'price' => 'required|numeric|min:0',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $subscription_plan = SubscriptionPlan::findOrFail($id);
    //     $subscription_plan->update($request->all());

    //     return redirect()->route('subscription.index')->with('success', 'Subscription plan updated successfully!');
    // }

    // public function destroy($id)
    // {
    //     $subscription_plan = SubscriptionPlan::findOrFail($id);
    //     $subscription_plan->delete();

    //     return redirect()->route('subscription.index')->with('success', 'Subscription plan deleted successfully!');
    // }
    public function subscribe(Request $request, $id)
    {

        
        //so we have a temporary storage which we later delete after the user has paid fully
        // Retrieve the authenticated user (you can use auth middleware to handle authentication)
        $user = auth()->user();
        $plan = Plan::find($id);
        $planPrice = PlanPrice::where('plan_id', $plan->id)->first();
        //info($planPrice);
        // Retrieve the selected subscription plan by ID
        //$subscriptionPlan = SubscriptionPlan::findOrFail($planId);
        TempSubscription::create([
            'user_id'=> $user->id,
            'plan_id' => $plan->id,
        ]);

        $paymentDetails = [
            'email' => $user->email, // User's email for Paystack
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'amount' => $planPrice->price * 100, // Amount in kobo
            //'reference' => Paystack::genTranxRef(), // Generate a unique reference
            "callback_url" => env('PAYSTACK_CALLBACK_URL'),
            'metadata' => [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
            ],
        ];

        // "amount" => intval(request()->amount) * $quantity,
        // "reference" => request()->reference,
        // "email" => request()->email,
        // "plan" => request()->plan,
        // "first_name" => request()->first_name,
        // "last_name" => request()->last_name,
        // "callback_url" => request()->callback_url,
        // "currency" => (request()->currency != ""  ? request()->currency : "NGN"),

        try {
            // Initialize payment and redirect user to Paystack payment page
            $paymentLink = Paystack::getAuthorizationUrl($paymentDetails)->redirectNow();
            

            return $paymentLink; // Redirect the user to Paystack payment page
        } catch (\Exception $e) {
            return back()->withError('Payment initialization failed: ' . $e->getMessage());
        }

    }

    public function handlePaymentCallback(Request $request)
    {
        // Handle Paystack payment callback here after user completes payment
        $paymentData = Paystack::getPaymentData();
     

        // Process payment data, update subscription status, and perform necessary actions
        // Update user subscription status based on payment status
        // $user = auth()->user();
        // $user_plan = TempSubscription::where('user_id', $user->id)->first();

        // $plan = Plan::find($user_plan->id);

        // $user->subscribeTo($plan);

        //send them an email that they have been subscribed

        return redirect()->route('dashboard')->with('success', 'Successfully subscribed!');
    }
    public function update(Request $request, Plan $plan)
    {
        auth()->user()->subscribeTo($plan);

        return redirect()->route('admin.plan.index');
    }
    

    //Switch to a plan
    public function switchPlan(Request $request, Plan $plan){

    }

    public function destroy(Plan $plan)
    {
        auth()->user()->subscription->cancel();

        return redirect()->route('admin.plan.index');
    }
}
