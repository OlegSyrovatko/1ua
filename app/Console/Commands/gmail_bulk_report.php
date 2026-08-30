<?php

namespace App\Console\Commands;

use App\Services\MailDeliveryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class gmail_bulk_report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail_bulk_report {--days=7}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gmail_bulk_report';

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
        $activeDays = (int) env('GMAIL_BULK_NEWS_ACTIVE_DAYS', 180);
        $dormantPercent = (int) Cache::store('database')->get(MailDeliveryService::GMAIL_DORMANT_PERCENT_KEY, 0);
        $changedAt = Cache::store('database')->get(MailDeliveryService::GMAIL_DORMANT_PERCENT_KEY . ':changed_at', '(ще не змінювався автотюнером)');
        $days = (int) $this->option('days');

        $this->info("Активний % для старих gmail-адрес: $dormantPercent% (остання зміна автотюнером: $changedAt)");
        $this->info("Поріг активності: $activeDays днів");
        $this->line('');

        $totalGmail = DB::table('users')
            ->where('email', 'like', '%@gmail.com')
            ->where('adm_send', '!=', '1')
            ->count();

        $activeGmail = DB::table('users')
            ->where('email', 'like', '%@gmail.com')
            ->where('adm_send', '!=', '1')
            ->where('l_visit', '>=', now()->subDays($activeDays))
            ->count();

        $blockedGmail = DB::table('mail_recipients')
            ->where('email', 'like', '%@gmail.com')
            ->where('status', 'blocked')
            ->count();

        $temporaryGmail = DB::table('mail_recipients')
            ->where('email', 'like', '%@gmail.com')
            ->where('status', 'temporary')
            ->count();

        $this->info('Аудиторія gmail.com для нічної розсилки:');
        $this->line("  усього підписників:            $totalGmail");
        $this->line("  активні (пройдуть завжди):     $activeGmail");
        $this->line("  вже заблоковані назавжди:       $blockedGmail (не отримають, навіть якщо активні)");
        $this->line("  тимчасово призупинені:          $temporaryGmail");
        $this->line('');

        $files = ['/var/log/exim4/mainlog'];
        for ($i = 1; $i <= $days; $i++) {
            $plain = "/var/log/exim4/mainlog.$i";
            $gz = "/var/log/exim4/mainlog.$i.gz";
            if (is_file($plain)) {
                $files[] = $plain;
            } elseif (is_file($gz)) {
                $files[] = $gz;
            }
        }
        $escaped = implode(' ', array_map('escapeshellarg', $files));

        $this->info("Доставка на gmail.com за exim-логами (запит: $days дн., реально доступно логів: " . count($files) . "):");

        $delivered = (int) shell_exec("zgrep -h 'for [^ ]*@gmail\\.com\$' $escaped 2>/dev/null | wc -l");
        // строго одержувачі на @gmail.com, не будь-який Google-хостинг (напр. сторонні домени на Workspace)
        $reputationBounces = (int) shell_exec(
            "zgrep -hE '\\*\\* [^ ]+@gmail\\.com .*550-5\\.7\\.1.*Gmail has detected' $escaped 2>/dev/null | wc -l"
        );
        $otherBounces = (int) shell_exec(
            "zgrep -hE '\\*\\* [^ ]+@gmail\\.com .*(550-5\\.1\\.1|452-4\\.2\\.2|552-5\\.2\\.2)' $escaped 2>/dev/null | wc -l"
        );

        $this->line("  успішних доставок (250 OK):                       $delivered");
        $this->line("  репутаційних відмов (550-5.7.1 'low reputation'): $reputationBounces  <- головний індикатор проблеми");
        $this->line("  інших відмов (unknown user/mailbox full):        $otherBounces");
        $this->line('');
        $this->line("  Детальніше: zgrep -E '\\*\\* [^ ]+@gmail\\.com .*550-5\\.7\\.1' " . implode(' ', $files));

        return 0;
    }
}
