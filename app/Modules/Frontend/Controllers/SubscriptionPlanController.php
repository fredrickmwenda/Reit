<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PlanPrice;
use App\Models\Subscription;
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
        if ($id === null) {

            // Handle the case when $id is null, for example, return a response or redirect
            return redirect()->back();
        }

   
        //so we have a temporary storage which we later delete after the user has paid fully
        // Retrieve the authenticated user (you can use auth middleware to handle authentication)
        $user = auth()->user();
        $plan = Plan::find($id);
        //add  the reference too in the temp subscription
        $planPrice = PlanPrice::where('plan_id', $plan->id)->first();
        $reference= Paystack::genTranxRef();
        //info($planPrice);
        // Retrieve the selected subscription plan by ID
        //$subscriptionPlan = SubscriptionPlan::findOrFail($planId);
        TempSubscription::create([
            'user_id'=> $user->id,
            'plan_id' => $plan->id,
            'reference' => $reference,
        ]);

        $paymentDetails = [
            'email' => $user->email, // User's email for Paystack
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'amount' => $planPrice->price * 100, // Amount in kobo
           'reference' => Paystack::genTranxRef(), // Generate a unique reference
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
        // Retrieve trxref and reference from the request query parameters
        $trxref = $request->query('trxref');
        $reference = $request->query('reference');
        
        // Handle Paystack payment callback here after the user completes payment
        $paymentData = Paystack::getPaymentData();
        
    
        // Process payment data, update subscription status, and perform necessary actions
        $user = auth()->user();
        $userPlan = TempSubscription::where('user_id', $user->id)->first();
    
        $plan = Plan::find($userPlan->plan_id);
    
        // Check if it is a renewal or first payment
        if ($userPlan->previous_plan) {
            // Subscription renewal
            $newPlan = Plan::find($userPlan->plan_id);
            $oldPlan = Plan::find($userPlan->previous_plan);
    
            // Switch to the new plan
            $user->switchTo($newPlan);
    
            // Optionally, perform additional actions based on the old plan (e.g., remove features)
            // ...
    
            // Clear the TempSubscription record after switching
            $userPlan->delete();
    
            return response()->json(['message' => 'Switched subscription plans successfully.'], 200);
        } else {
            // First-time subscription
            if ($user->isSubscribedTo($plan)) {
                // Subscription already exists, perform a renewal (optional)
                $user->subscription->renew();
                $userPlan->delete();
                return response()->json(['message' => 'Subscription renewed successfully.'], 200);
            } else {
                // First-time subscription
                try {
                    $user->subscribeTo($plan);
    
                    // Clear the TempSubscription record after first-time subscription
                    $userPlan->delete();
    
                    return response()->json(['message' => 'Subscription created successfully.'], 200);
                } catch (\Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }
        }
    
        // Redirect or return response as needed
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
