<?php

namespace App\Console\Commands;

use App\Services\MailDeliveryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class gmail_bulk_autotune extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail_bulk_autotune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gmail_bulk_autotune';

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
        $step = (int) env('GMAIL_BULK_NEWS_STEP', 3);
        $ceiling = (int) env('GMAIL_BULK_NEWS_CEILING', 25);
        $cooldownDays = (int) env('GMAIL_BULK_NEWS_COOLDOWN_DAYS', 2);
        $lookbackDays = (int) env('GMAIL_BULK_NEWS_LOOKBACK_DAYS', 3);

        $cache = Cache::store('database');
        $key = MailDeliveryService::GMAIL_DORMANT_PERCENT_KEY;
        $changedAtKey = $key . ':changed_at';

        $current = (int) $cache->get($key, 0);

        // Свідомо НЕ через mail_recipients.updated_at: після одноразового розбору
        // 81к накопичених DSN-листів (30.08.2026) там перемішані дати самих подій
        // з датою, коли ми їх обробили. exim mainlog — єдине джерело з реальним
        // часом доставки.
        $reputationBounces = $this->countReputationBouncesInLogs($lookbackDays);

        $lastChangedAt = $cache->get($changedAtKey);

        if ($reputationBounces > 0) {
            $new = intdiv($current, 2);
            $reason = "виявлено $reputationBounces репутаційних bounce на gmail.com за $lookbackDays дн. — відкат наполовину";
        } elseif ($lastChangedAt && now()->diffInDays($lastChangedAt) < $cooldownDays) {
            $new = $current;
            $reason = 'cooldown після останньої зміни ще не минув, чекаємо';
        } elseif ($current >= $ceiling) {
            $new = $current;
            $reason = "досягнута стеля $ceiling% — далі підняти можна тільки вручну (GMAIL_BULK_NEWS_CEILING)";
        } else {
            $new = min($ceiling, $current + $step);
            $reason = "$lookbackDays дн. без репутаційних bounce — обережно піднімаємо";
        }

        if ($new !== $current) {
            $cache->forever($key, $new);
            $cache->forever($changedAtKey, now()->toDateTimeString());
        }

        $message = "GMAIL_BULK_AUTOTUNE: $current% -> $new% ($reason)";
        \Log::info($message);
        $this->info($message);

        return 0;
    }

    private function countReputationBouncesInLogs(int $lookbackDays): int
    {
        $files = ['/var/log/exim4/mainlog'];
        for ($i = 1; $i <= $lookbackDays; $i++) {
            $plain = "/var/log/exim4/mainlog.$i";
            $gz = "/var/log/exim4/mainlog.$i.gz";
            if (is_file($plain)) {
                $files[] = $plain;
            } elseif (is_file($gz)) {
                $files[] = $gz;
            }
        }

        $escaped = implode(' ', array_map('escapeshellarg', $files));

        // Обов'язково прив'язуємось до одержувача саме на @gmail.com (рядок "** email R=..."),
        // інакше сюди потрапляють і сторонні домени на Google Workspace (напр. окрема мертва
        // скринька на кастомному домені), що не має стосунку до репутації для звичайних gmail.com.
        return (int) trim((string) shell_exec(
            "zgrep -hE '\\*\\* [^ ]+@gmail\\.com .*550-5\\.7\\.1.*Gmail has detected' $escaped 2>/dev/null | wc -l"
        ));
    }
}
