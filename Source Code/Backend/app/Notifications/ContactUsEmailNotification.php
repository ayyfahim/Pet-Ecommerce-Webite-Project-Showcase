<?php

namespace App\Notifications;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContactUsEmailNotification extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject($this->data['subject'])
            ->from($this->data['from'], $this->data['to'])
            ->view("emails.en.email", [
                'userName' => $this->data['full_name'],
                'body' => $this->data["body"],
            ]);
    }
}
