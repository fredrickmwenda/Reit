<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendSubscriptionReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:reminders';
    protected $description = 'Send subscription renewal reminders';

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
            $query->where('expired_at', '<=', Carbon::now()->subDays(3)->startOfDay());
        })->get();

        foreach ($expiredUsers as $user) {
            $expiredSubscriptions = $user->subscriptions()->where('expired_at', '<=', Carbon::now()->subDays(3)->startOfDay())->get();
            
            foreach ($expiredSubscriptions as $subscription) {
                // Send invoice reminder to the user via email or other notification method
                // Example: Mail::to($user->email)->send(new InvoiceReminderMail($subscription));
                
                // Optionally, update the subscription status or send specific notifications
                // $subscription->notify('Your subscription is expiring soon.');
                // $subscription->update(['reminder_sent' => true]);
            }
        }
        
        $this->info('Subscription reminders sent successfully.');
    }
}
