<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class RebuildHeroDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $poolOnly;

    /**
     * Create a new job instance.
     *
     * @param bool $poolOnly  Перебудувати лише добірку "найкраще", не чіпаючи знімок/cooldown
     *                        трендів "найпопулярніше за добу" (щоб позачергові виклики, напр. з
     *                        кнопки "прибрати фото", не збивали годинник приросту переглядів).
     * @return void
     */
    public function __construct($poolOnly = false)
    {
        $this->poolOnly = $poolOnly;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('hero_build', $this->poolOnly ? ['--pool-only' => true] : []);
    }
}
