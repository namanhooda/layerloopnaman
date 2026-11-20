<?php

namespace App\Notifications;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractExpiryNotification extends Notification
{
    use Queueable;

    public function __construct(public Contract $contract, public int $days) {}
    public function via($notifiable): array { return ['mail']; }
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('LayerLoop contract expiry reminder')
            ->line("Contract {$this->contract->contract_number} expires in {$this->days} days.")
            ->line($this->contract->title)
            ->action('View contract', route('admin.contracts.show', $this->contract));
    }
}
