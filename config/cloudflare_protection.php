<?php

return [

    // Поки true — жодних звернень до Cloudflare API. Аналіз, attack score, стан і всі дії,
    // які СИСТЕМА ЗРОБИЛА Б, лише пишуться в лог cloudflare-protection. Явно вимкнути (false)
    // повинен сам власник сайту, після перегляду логів за кілька днів.
    'monitor_only' => env('CLOUDFLARE_PROTECTION_MONITOR_ONLY', true),

    'cloudflare' => [
        'api_token' => env('CLOUDFLARE_API_TOKEN'),
        'zone_id' => env('CLOUDFLARE_ZONE_ID'),
        // Custom rule (http_request_firewall_custom ruleset), яке ставить managed_challenge
        // на підозрілий/атакуючий трафік. Створюється вручну один раз в Cloudflare dashboard,
        // сюди — лише id, щоб сервіс міг вмикати/вимикати/редагувати саме це правило.
        'ruleset_id' => env('CLOUDFLARE_RULESET_ID'),
        'rule_id' => env('CLOUDFLARE_RULE_ID'),
    ],

    // Джерело даних — той самий ip.txt, який вже пише layouts/app.blade.php на кожен запит.
    'ip_log_path' => storage_path('app/public/ip.txt'),

    // Apache access-лог цього vhost'у — читаємо лише дельту (новий байтовий діапазон з
    // минулого циклу), щоб рахувати 4xx/5xx без повторного парсингу багатогігабайтного файлу.
    'access_log_path' => env(
        'CLOUDFLARE_PROTECTION_ACCESS_LOG',
        '/var/www/site_user/data/logs/1ua.com.ua-frontend.access.log'
    ),

    // Скільки хвилинних зрізів тримати в Redis для розрахунку baseline (24 год за замовчуванням).
    'history_size' => (int) env('CLOUDFLARE_PROTECTION_HISTORY_SIZE', 1440),

    // Мінімум "нормальних" зрізів, перш ніж baseline вважається достатньо надійним для
    // розрахунку deviation-складової attack score. Поки їх менше — ця складова дає 0 балів.
    'baseline_min_samples' => (int) env('CLOUDFLARE_PROTECTION_BASELINE_MIN_SAMPLES', 30),

    'thresholds' => [
        'suspicious_score' => (int) env('CLOUDFLARE_PROTECTION_SUSPICIOUS_SCORE', 40),
        'attack_score' => (int) env('CLOUDFLARE_PROTECTION_ATTACK_SCORE', 70),
        // Одноразовий екстремальний score, що вмикає ATTACK одразу, без очікування
        // послідовних циклів (для дуже сильного одномоментного сплеску).
        'attack_score_immediate' => (int) env('CLOUDFLARE_PROTECTION_ATTACK_SCORE_IMMEDIATE', 92),
        // Незалежний від attack score "запобіжник": load5 понад це значення сам по
        // собі одразу вмикає ATTACK (Under Attack Mode), навіть якщо score низький.
        // load5 (не load1 — надто шумний, не load15 — надто повільний) як компроміс
        // між швидкістю реакції та стійкістю до одноразових сплесків. На відміну від
        // anomaly-складової load15 в AttackDetectionService (яка не спрацьовує без
        // інших сигналів), це прямий поріг місткості сервера.
        'load_attack_threshold' => (float) env('CLOUDFLARE_PROTECTION_LOAD_ATTACK_THRESHOLD', 6),
    ],

    // Гістерезис: скільки послідовних циклів (~1 хв кожен) потрібно провести на певному
    // рівні score, перш ніж РЕАЛЬНО змінити стан. Вхід — швидкий, вихід — повільний.
    'hysteresis' => [
        'suspicious_enter_cycles' => (int) env('CLOUDFLARE_PROTECTION_SUSPICIOUS_ENTER_CYCLES', 2),
        'attack_enter_cycles' => (int) env('CLOUDFLARE_PROTECTION_ATTACK_ENTER_CYCLES', 3),
        'suspicious_exit_cycles' => (int) env('CLOUDFLARE_PROTECTION_SUSPICIOUS_EXIT_CYCLES', 5),
        'attack_exit_cycles' => (int) env('CLOUDFLARE_PROTECTION_ATTACK_EXIT_CYCLES', 15),
    ],

    'telegram' => [
        'notify' => (bool) env('CLOUDFLARE_PROTECTION_TELEGRAM_NOTIFY', true),
    ],
];
