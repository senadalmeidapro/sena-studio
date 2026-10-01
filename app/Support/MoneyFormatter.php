<?php

namespace App\Support;

use App\Enums\Currency;

class MoneyFormatter
{
    public function format(int $amount, Currency|string $currency): string
    {
        $code = $currency instanceof Currency ? $currency->value : $currency;
        $major = $code === Currency::EUR->value ? $amount / 100 : $amount;
        $decimals = $code === Currency::EUR->value ? 2 : 0;

        return number_format($major, $decimals, ',', ' ').' '.$code;
    }
}
