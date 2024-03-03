<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountantNotification extends Notification
{
    use Queueable;
    private $client;
    /**
     * Create a new notification instance.
     */
    public function __construct($client)
    {
        // dd($client);
        $this->client = $client;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->client['user_id'],
            'client_id' => $this->client['id'],
            'client_type' => $this->client['client_type'],
            // 'client_type' => $request->client_type,
        ];
    }
}
