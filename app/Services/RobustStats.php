<?php

namespace App\Services;

/**
 * Медіана + MAD (median absolute deviation) замість mean/stddev — щоб один
 * аномальний день (чи одна атака) не спотворював "типове значення" так, як це
 * зробило б звичайне середнє. MAD масштабується коефіцієнтом 1.4826, щоб на
 * приблизно нормальному розподілі відповідати класичному стандартному
 * відхиленню (стандартна практика для "робастного sigma").
 *
 * Чисто математичний клас без Redis/БД — щоб той самий код однаково рахував
 * і в проді (BaselineRepository, дані з Redis), і в backtest (дані з
 * історичного логу, у пам'яті) — інакше backtest міг би "брехати" про те,
 * що реально станеться в проді.
 */
class RobustStats
{
    private const MAD_SCALE = 1.4826;

    /**
     * @param float[] $samples
     * @param float $minSigma Нижня межа "робастної сигми" для цієї метрики,
     *                        щоб на дуже стабільних величинах (MAD≈0) крихітні
     *                        коливання не давали штучно величезний z-score.
     * @return array{median: float, sigma: float, samples: int}|null null, якщо
     *         зразків замало, щоб взагалі щось порахувати.
     */
    public static function compute(array $samples, float $minSigma): ?array
    {
        $samples = array_values(array_filter($samples, fn ($v) => $v !== null));
        $count = count($samples);

        if ($count === 0) {
            return null;
        }

        sort($samples);
        $median = self::median($samples);

        $deviations = array_map(fn ($v) => abs($v - $median), $samples);
        sort($deviations);
        $mad = self::median($deviations);

        $sigma = max($mad * self::MAD_SCALE, $minSigma);

        return ['median' => $median, 'sigma' => $sigma, 'samples' => $count];
    }

    /**
     * Модифікований z-score (Iglewicz & Hoaglin) відносно робастного baseline.
     */
    public static function zScore(float $value, array $baseline): float
    {
        if ($baseline['sigma'] <= 0) {
            return 0.0;
        }

        return ($value - $baseline['median']) / $baseline['sigma'];
    }

    private static function median(array $sorted): float
    {
        $count = count($sorted);
        $mid = intdiv($count, 2);

        if ($count % 2 === 0) {
            return ($sorted[$mid - 1] + $sorted[$mid]) / 2;
        }

        return $sorted[$mid];
    }
}
