<?php

namespace App\Services;

use App\Models\MailRecipient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MailDeliveryService
{
    public const GMAIL_DORMANT_PERCENT_KEY = 'gmail_bulk_news_dormant_percent';

    /**
     * Чи можна слати нічну bulk-новину на gmail.com-адресу.
     * Поступове відновлення розсилки після інциденту з репутацією (26.07.2026):
     * спочатку тільки живі підписники (заходили на сайт за GMAIL_BULK_NEWS_ACTIVE_DAYS днів),
     * решта ("старі" адреси) підключаються поступово через відсоток, який щодня
     * коригує gmail_bulk_autotune (див. цю команду) і зберігає в database-кеші —
     * не в .env, бо queue:work довгоживучий процес і не перечитує .env на льоту.
     */
    public static function gmailBulkNewsAllowed(string $email): bool
    {
        $email = strtolower(trim($email));
        $activeDays = (int) env('GMAIL_BULK_NEWS_ACTIVE_DAYS', 180);
        $dormantPercent = (int) Cache::store('database')->get(self::GMAIL_DORMANT_PERCENT_KEY, 0);

        $lastVisit = DB::table('users')->where('email', $email)->value('l_visit');

        if ($lastVisit && $lastVisit !== '0000-00-00 00:00:00'
            && Carbon::parse($lastVisit)->greaterThanOrEqualTo(now()->subDays($activeDays))
        ) {
            return true;
        }

        if ($dormantPercent <= 0) {
            return false;
        }

        return (crc32($email) % 100) < $dormantPercent;
    }

    public static function canSend(string $email): bool
    {
      
        // російські домени навіть не пробуємо
        $email = strtolower(trim($email));
        $domain = strtolower(substr(strrchr($email, "@"), 1));

        if (str_ends_with($domain, '.ru')) {
            return false;
        }
        if (preg_match('/\.ru$/i', $domain)) {
            return false;
        }

        $recipient = MailRecipient::where('email', $email)->first();

        if (!$recipient) {
            return true;
        }

        if ($recipient->status === 'blocked') {
            return false;
        }

        if (
            $recipient->status === 'temporary'
            && $recipient->next_retry_at
            && $recipient->next_retry_at->isFuture()
        ) {
            return false;
        }

        return true;
    }

    public static function markFailure(string $email, string $reason): void
    {
        $recipient = MailRecipient::firstOrNew([
            'email' => strtolower($email),
        ]);

        $recipient->fail_count = ($recipient->fail_count ?? 0) + 1;
        $recipient->last_error = mb_substr($reason, 0, 255);

        if ($recipient->fail_count >= 3) {
            $recipient->status = 'blocked';
            $recipient->next_retry_at = null;
        } else {
            $recipient->status = 'temporary';
            $recipient->next_retry_at = now()->addHours(6);
        }

        $recipient->save();
    }

    public static function isSmtpError(\Throwable $e): bool
    {
        $msg = strtolower($e->getMessage());

        return
            str_contains($msg, 'smtp') ||
            str_contains($msg, 'mailbox') ||
            str_contains($msg, 'recipient') ||
            str_contains($msg, '550') ||
            str_contains($msg, '551') ||
            str_contains($msg, '552') ||
            str_contains($msg, '553') ||
            str_contains($msg, '554') ||
            str_contains($msg, '421') ||
            str_contains($msg, '451') ||
            str_contains($msg, '452');
    }
}