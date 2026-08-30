<?php

namespace App\Console\Commands;

use App\Services\MailDeliveryService;
use Illuminate\Console\Command;

class process_mail_bounces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process_mail_bounces {--limit=3000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'process_mail_bounces';

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
        $maildir = env('MAIL_BOUNCE_MAILDIR', '/var/www/site_user/data/email/1ua.com.ua/no_reply/.maildir');
        $newDir = $maildir . '/new';
        $trashDir = $maildir . '/.Trash/cur';

        if (!is_dir($newDir) || !is_dir($trashDir)) {
            $this->error("Maildir не знайдено: $newDir");
            return 1;
        }

        $limit = (int) $this->option('limit');
        $files = array_diff(scandir($newDir), ['.', '..']);
        $files = array_slice($files, 0, $limit);

        $marked = 0;
        $trashed = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $path = $newDir . '/' . $file;
            if (!is_file($path)) {
                continue;
            }

            $raw = @file_get_contents($path);
            if ($raw === false) {
                // інший процес (наприклад, паралельний запуск планувальника) вже забрав цей файл
                continue;
            }
            if (!str_contains($raw, 'Mailer-Daemon')) {
                $skipped++;
                continue;
            }

            foreach ($this->parseBounce($raw) as $entry) {
                if ($entry['action'] !== 'failed') {
                    continue;
                }
                MailDeliveryService::markFailure($entry['email'], $entry['diagnostic']);
                $marked++;
            }

            if (@rename($path, $trashDir . '/' . $file)) {
                $trashed++;
            }
        }

        $this->info("Оброблено файлів: " . count($files) . ", позначено відмов: $marked, у trash: $trashed, пропущено (не bounce): $skipped");

        return 0;
    }

    /**
     * @return array<int, array{email: string, action: string, diagnostic: string}>
     */
    private function parseBounce(string $raw): array
    {
        $entries = [];
        $blocks = preg_split('/(?=^Action:)/mi', $raw);

        foreach ($blocks as $block) {
            if (!preg_match('/^Final-Recipient:\s*rfc822;\s*(\S+)/mi', $block, $recipientMatch)) {
                continue;
            }
            if (!preg_match('/^Action:\s*(\S+)/mi', $block, $actionMatch)) {
                continue;
            }

            $diagnostic = '';
            if (preg_match('/^Diagnostic-Code:\s*(.+)$/mi', $block, $diagMatch)) {
                $diagnostic = trim($diagMatch[1]);
            } elseif (preg_match('/^Status:\s*(\S+)/mi', $block, $statusMatch)) {
                $diagnostic = 'status ' . $statusMatch[1];
            }

            $entries[] = [
                'email' => strtolower(trim($recipientMatch[1], " \t\r\n<>")),
                'action' => strtolower($actionMatch[1]),
                'diagnostic' => mb_substr($diagnostic, 0, 255),
            ];
        }

        return $entries;
    }
}
