<?php

namespace App\Modules\Backend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PlanPrice;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\TempSubscription;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Unicodeveloper\Paystack\Facades\Paystack;

class SubscriptionController extends Controller

{
    public function index()
    {
        $subcriptionPlans = Plan::with('features')->get();


        return view('Backend::screens.admin.subscriptions.index', compact('subcriptionPlans'));
    }

    // subscriptions and the're statuses
    public function show(Request $request)
    {
        $status = $request->input('status');

        $subscriptions = Subscription::query();

        switch ($status) {
            case 'expired':
                $subscriptions->where('expired_at', '<', Carbon::now());
                break;

            case 'not_started':
                $subscriptions->whereNull('started_at');
                break;

            case 'cancelled':
                $subscriptions->whereNotNull('canceled_at');
                break;

                // Add more cases as needed
            case 'active':
                $subscriptions->where('expired_at', '>', Carbon::now());
                break;


            default:
                // Handle the default case or leave it empty for 'all' subscriptions
                break;
        }

        $subscriptions = $subscriptions->get();
        return view('Backend::screens.admin.subscriptions.show', compact('subscriptions', 'status'));
    }

    // all plans
    public function subscriptionPlans()
    {
        $subcriptionPlans = Plan::with('features', 'prices')->get();
        // dd($subcriptionPlans);

        return view('Backend::screens.partner.subscriptions.index', compact('subcriptionPlans'));
    }

    public function partner_subscriptions(Request $request)
    {
        $status = $request->input('status');

        $user = Auth::user();

        if ($status === 'renewals') {
            $subscriptions = $user->renewals();
        } else {
            $subscriptions = $user->subscriptions();

            switch ($status) {
                case 'expired':
                    $subscriptions->where('expired_at', '<', Carbon::now());
                    break;

                case 'not_started':
                    $subscriptions->whereNull('started_at');
                    break;

                case 'cancelled':
                    $subscriptions->whereNotNull('canceled_at');
                    break;

                case 'active':
                    $subscriptions->where('expired_at', '>', Carbon::now());
                    break;

                default:
                    // Handle the default case or leave it empty for 'all' subscriptions
                    break;
            }
        }

        $subscriptions = $subscriptions->get();
        return view('Backend::screens.partner.subscriptions.show', compact('subscriptions', 'status'));
    }



    //a 

    public function create()
    {
        $features = Feature::all();
        //dd($features);

        return view('Backend::screens.admin.subscriptions.new', compact('features'));
    }


    public function store(Request $request)
    {
        // Validate request data if needed

        //dd($request->all());
        // Create a Plan
        $plan = Plan::create([
            'name'             => $request->input('name'),
            'periodicity_type' => $request->input('periodicity_type'),
            'periodicity'      => $request->input('periodicity'),
            'grace_days'       => $request->input('grace_days'),
        ]);

        // Attach selected features to the Plan
        $plan->features()->attach($request->input('features'));

        // Create Plan Price
        PlanPrice::create([
            'plan_id' => $plan->id,
            'price'   => $request->input('price'),
        ]);

        return redirect()->route('subscription.index')->with('message', 'Subscription created succcessfully');
    }

    public function edit($id)
    {
        $subscription = Plan::findOrFail($id);
    
        // Retrieve the selected feature IDs for the given plan
        $selectedFeatures = $subscription->features()->pluck('features.id')->toArray();

        // dd($selectedFeatureIds);
    
        $features = Feature::all();
    
        return view('Backend::screens.admin.subscriptions.edit', compact('subscription', 'features', 'selectedFeatures'));
    }

    // public function update(Request $request, $id)
    // {
    //     try {
    //         // Validate request data if needed
    //         // Find the Plan by ID
    //         $plan = Plan::findOrFail($id);

    //         // Update Plan details
    //         $plan->update([
    //             'name'             => $request->input('name'),
    //             'periodicity_type' => $request->input('periodicity_type'),
    //             'periodicity'      => $request->input('periodicity'),
    //             'grace_days'       => $request->input('grace_days'),
    //         ]);

    //         // Update or create Plan Price
    //         $planPrice = PlanPrice::where('plan_id', $plan->id)->first();

    //         $planPrice->update([
    //             'price' => $request->input('price'),
    //         ]);

    //         return redirect()->route('subscription.index')->with('message', 'Plan updated successfully');
    //     } catch (QueryException $exception) {
    //         // Handle database-related exceptions
    //         return redirect()->route('subscription.index')->with('error', 'Database error: ' . $exception->getMessage());
    //     } catch (\Exception $exception) {
    //         // Handle other types of exceptions
    //         return redirect()->route('subscription.index')->with('error', 'An error occurred: ' . $exception->getMessage());
    //     }
    // }

    public function update(Request $request, $id)
    {
        // Validate request data if needed
//dd($request->all());
        // Find the Plan by ID
        $plan = Plan::findOrFail($id);


        // Update the Plan
        $plan->update([
            'name'             => $request->input('name'),
            'periodicity_type' => $request->input('periodicity_type'),
            'periodicity'      => $request->input('periodicity'),
            'grace_days'       => $request->input('grace_days'),
        ]);

        // Sync selected features to the Plan
        $plan->features()->sync($request->input('features'));

        // Update Plan Price
        $plan->prices->update([
            'price' => $request->input('price'),
        ]);

        return redirect()->route('subscription.index')->with('message', 'Subscription updated successfully');
    }



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
        $reference = Paystack::genTranxRef();
        //info($planPrice);
        // Retrieve the selected subscription plan by ID
        //$subscriptionPlan = SubscriptionPlan::findOrFail($planId);
        if ($user->subscription) {
            // Compare the existing plan with the new plan
            $existingPlan = $user->subscription->plan;

            if ($existingPlan->id != $plan->id) {
                // User is trying to subscribe to a different plan, update TempSubscription
                TempSubscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'reference' => $reference,
                    'previous_plan' => $existingPlan->id,
                ]);
            } else {
                TempSubscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'reference' => $reference,

                ]);
            }
        } else {
            TempSubscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'reference' => $reference,

            ]);
        }
        // check if the user has an existing subscription plan different from the one they're getting into

        // TempSubscription::create([
        //     'user_id'=> $user->id,
        //     'plan_id' => $plan->id,
        //     'reference' => $reference,

        // ]);

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

    //switch plans

    public function switchPlan(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Find the new plan based on the request input
        $newPlan = Plan::find($request->input('plan_id'));

        // Check if the user exists and has an active subscription
        if ($user && $user->subscription) {
            try {
                // Use the trait method to switch to the new plan
                $newSubscription = $user->switchTo($newPlan);

                // Optionally perform any additional actions or return a response
                return response()->json([
                    'message' => 'Subscription switched successfully.',
                    'new_subscription' => $newSubscription,
                ], 200);
            } catch (\Exception $e) {
                // Handle any exceptions or errors that might occur during the switch
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'User not found or no active subscription.'], 404);
        }
    }




    public function destroy($id)
    {
        try {
            $plan = Plan::findOrFail($id);

            // Check if there are users subscribed to this plan
            $subscribedUsersCount = Subscription::where('plan_id', $plan->id)->count();

            if ($subscribedUsersCount > 0) {
                return redirect()->back()->with('error', 'Cannot delete plan. There are users subscribed to this plan.');
            }

            // You may want to perform additional checks or actions before deleting
            // ...

            $plan->delete();

            return redirect()->back()->with('success', 'Plan deleted successfully.');
        } catch (\Exception $e) {
            // Handle exception if needed
            return redirect()->back()->with('error', 'Failed to delete plan.');
        }
    }
}
