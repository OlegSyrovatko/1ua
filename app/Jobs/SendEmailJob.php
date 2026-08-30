<?php

namespace App\Jobs;

use App\Models\MailRecipient;
use App\Services\MailDeliveryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }



    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $blade = $this->details['blade'];
        $subject = $this->details['subject'];
        $to = $this->details['email'];

        // поступове відновлення нічної розсилки новин на gmail.com після інциденту
        // з репутацією 26.07.2026: див. MailDeliveryService::gmailBulkNewsAllowed()
        $bulkNewsBlades = ['emails.city_newsme', 'emails.rcity_newsme', 'emails.ecity_newsme'];
        if (in_array($blade, $bulkNewsBlades, true) && str_ends_with(strtolower(strrchr($to, '@')), '@gmail.com')) {
            if (! MailDeliveryService::gmailBulkNewsAllowed($to)) {
                return;
            }
        }

        if (! MailDeliveryService::canSend($to)) {
            // \Log::info('MAIL BLOCKED: ' . $to);
            return;
        }
        $det = $this->details['det'];
        $unsub = $this->details['unsub'];

        try {
            // \Log::info('MAIL START', [
            //     'email' => $to,
            // ]);
            Mail::send($blade, $det, function ($message) use ($to, $subject, $unsub) {

                if (mb_strlen($unsub) > 10) {
                    $message->getHeaders()->addTextHeader('List-Unsubscribe', $unsub);
                }

                $message->subject($subject)->to($to);
            });
            // throw new \Exception('TEST');
            // \Log::info('MAIL ACCEPTED', [
            //     'email' => $to,
            // ]);
            // \Log::info('STEP 5');


        }

        catch (\Throwable $e) {
            \Log::error('MAIL EXCEPTION', [
                'email' => $to,
                'message' => $e->getMessage(),
                'class' => get_class($e),
            ]);
            if (MailDeliveryService::isSmtpError($e)) {
                MailDeliveryService::markFailure(
                    $to,
                    $e->getMessage()
                );
            }
            // MailDeliveryService::markFailure(
            //     $to,
            //     $e->getMessage()
            // );

            throw $e;
        }

    }
}
