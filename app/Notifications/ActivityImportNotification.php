<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Carbon\Carbon;

class ActivityImportNotification extends Notification
{
    use Queueable;
     /**
     * @var string
     */
    public $userName;

    /**
     * @var string
     */
    public $activityTitle;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userName, $activityTitle)
    {
        $this->userName = $userName;
        $this->activityTitle = $activityTitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello '. $this->userName . '!')
                    ->line('Your import of Activity ['.$this->activityTitle.'] has been completed. Please log back into <a href="'.url('/').'">CurrikiStudio</a> and navigate to Independent Activities section to access your shiny new independent activity!')
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => "Activity [$this->activityTitle] has been imported successfully.",
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        $timestamp = Carbon::parse(now()->addSecond()->toDateTimeString());
        return new BroadcastMessage(array(
            'notifiable_id' => $notifiable->id,
            'notifiable_type' => get_class($notifiable),
            'data' => $this->toDatabase($notifiable),
            'notifiable' => $notifiable,
            'read_at' => null,
            'created_at' => $timestamp->diffForHumans(),
            'updated_at' => $timestamp->diffForHumans(),
        ));
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
