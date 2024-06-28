<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifySubscriptionExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:notify-expired';
    protected $description = 'Notify users of expired subscriptions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredUsers = User::whereHas('subscriptions', function ($query) {
            $query->where('expired_at', '<=', Carbon::now()->subDays(7)->startOfDay()) // Subscriptions that have expired
                ->whereNull('canceled_at'); // User hasn't renewed the subscription (assuming 'canceled_at' is set when subscription is canceled)
        })->get();

        foreach ($expiredUsers as $user) {
            $expiredSubscriptions = $user->subscriptions()
                ->where('expired_at', '<=', Carbon::now()->subDays(3)->startOfDay()) // Subscriptions that have expired
                ->whereNull('canceled_at') // User hasn't renewed the subscription (assuming 'canceled_at' is set when subscription is canceled)
                ->get();

            foreach ($expiredSubscriptions as $subscription) {
                // Send expiration notification to the user via email or other notification method
                // Example: Mail::to($user->email)->send(new SubscriptionExpiredMail($subscription));

                // Optionally, update the subscription status or send specific notifications
                // $subscription->notify('Your subscription has expired.');
                // $subscription->update(['expired_notification_sent' => true]);
            }
        }

        $this->info('Subscription expiration notifications sent successfully.');
    }
}
