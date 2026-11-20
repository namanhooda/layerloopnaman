<?php

namespace App\Console\Commands;

use App\Models\Contract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContractExpiryNotification;

class SendContractExpiryReminders extends Command
{
    protected $signature = 'contracts:send-expiry-reminders';
    protected $description = 'Send contract expiry reminders to configured administrators';

    public function handle(): int
    {
        $days = config('layerloop-contracts.expiry_reminder_days', [30,15,7]);
        foreach ($days as $day) {
            $date = now()->addDays((int) $day)->toDateString();
            $contracts = Contract::whereIn('status', ['active','signed'])
                ->whereDate('end_date', $date)->get();

            foreach ($contracts as $contract) {
                $contract->logActivity('expiry_reminder_due', "Expiry reminder threshold reached: {$day} days.");
                // Configure recipient(s) and notification channel before enabling dispatch.
                // Notification::route('mail', config('mail.contract_admin'))->notify(new ContractExpiryNotification($contract, $day));
            }
        }
        $this->info('Expiry reminder scan completed.');
        return self::SUCCESS;
    }
}
