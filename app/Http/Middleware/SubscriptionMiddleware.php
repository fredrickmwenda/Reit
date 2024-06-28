<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

        
        public function handle(Request $request, Closure $next)
        {
            $user = Auth::user();
    
            // Check if the user has the 'partner' role
            if ($user && $user->hasRole('partner')) {
                $subscriptionLevel = $user->getSubscriptionLevelAttribute() ?? 'defaultSubscription';
    
                // Check if the subscription level is not null
                if ($subscriptionLevel) {
                    $serviceCounts = $user->createdServicesCount();
                    $maxListings = $this->getMaxListingsForSubscription($subscriptionLevel);
    
                    // If not subscribed or exceeds the allowed listings
                    if (optional($user->subscription)->existsts) {
                        
                        // Check if the user has exceeded the allowed listings
                        if (array_sum($serviceCounts) > $maxListings) {
                            return redirect()->route($this->getRedirectRoute($subscriptionLevel));
                        }
                    
                        // If not subscribed or exceeds the allowed listings, redirect to appropriate service
                        return redirect()->route($this->getRedirectRoute($subscriptionLevel));
                    }
                    else{
                        //dd(array_sum($serviceCounts));
                        if  (array_sum($serviceCounts) > 1){
                            //dd($serviceCounts);
                            return redirect()->route('all-cars');

                        }
                        
                    }

                } else {
                    // Handle the case where the subscription level is null (provide a default action)
                    return redirect()->route('car');
                }
            }
    
            return $next($request); // User is subscribed or doesn't have 'partner' role, proceed with the request
        }
    
        // Add your getMaxListingsForSubscription and getRedirectRoute methods here
    
    

    private function getMaxListingsForSubscription($subscriptionLevel)
    {

        switch ($subscriptionLevel) {
            case 'basic':
                return 3;
            case 'professional':
                return 5;
            case 'pro':
                return PHP_INT_MAX; // Unlimited
            default:
                return 1; // Default to one listing if subscription level is not recognized
        }
    }

    private function getRedirectRoute($subscriptionLevel)
    {
        switch ($subscriptionLevel) {
            case 'basic':
                return 'all-cars'; // Redirect to the 'car' service for basic subscription
            case 'professional':
                return 'all-cars'; // Redirect to the 'car' service for professional subscription
            case 'pro':
                return 'all-cars'; // Redirect to the 'car' service for pro subscription
            default:
                return 'all-cars'; // Default to 'car' service if subscription level is not recognized
        }
    }
}
