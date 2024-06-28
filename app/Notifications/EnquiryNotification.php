<?php

namespace App\Notifications;

use App\Mail\SendEmailEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class EnquiryNotification extends Notification
{
    use Queueable;
    protected $enquiry;
    protected $postObject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($enquiry, $postObject)
    {
        $this->enquiry = $enquiry;
        $this->postObject = $postObject;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $postType = $this->enquiry['post_type'];
        $siteName = get_translate(get_option('site_name'));
        $subject = sprintf(__('[%s] %s Booking Enquiry'), $siteName, ucfirst($postType));
        $emailFrom = 'no-reply@example.com'; // Replace with the desired sender email address
    
        $adminUserId = get_option('admin_user');
        $postAuthor = $this->postObject['author'];
    
        // Send email to the admin user
        if ($adminUserId) {
            $adminUser = get_user_data($adminUserId);
            if ($adminUser) {
                $email = new SendEmailEnquiry($this->enquiry, $this->postObject, 'admin', $adminUser['id']);
                Mail::to($adminUser['email'])->send($email);
            }
        }
    
        // Send email to the post author
        if ($postAuthor) {
            $authorData = get_user_data($postAuthor);
            if ($authorData) {
                $email = new SendEmailEnquiry($this->enquiry, $this->postObject, 'author', $authorData['id']);
                Mail::to($authorData['email'])->send($email);
            }
        }
    
        // Send confirmation email to the user who made the enquiry
        return (new MailMessage)
                    ->subject($subject)
                    ->from($siteName)
                    ->view('Frontend::emails.' .  '.' . $postType . '-enquiry', [
                        
                        'post' => $this->postObject,
                        'post_data' => $this->enquiry,
                    ])
                    ->line('Thank you for your enquiry. We are working on it and will get back to you soon.');
                    // ->action('View Your Enquiry', url('/enquiries/' . $this->enquiry['id']));
    }
    

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
