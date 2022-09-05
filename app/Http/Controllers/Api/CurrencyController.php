<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\CurrencyValue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class CurrencyController extends Controller
{
    public function list()
    {
        return Currency::all();
    }

    public function getByCode(string $charCode, ?string $date = null)
    {
        if ($date === null) {
            $date = Carbon::now()->format('Y-m-d');
        }

        $currency = Currency::query()->where('char_code', '=', strtoupper($charCode))->first();
        $currencyValue = CurrencyValue::query()
            ->where('code', '=', $currency->code)
            ->where('date', '=', $date)
            ->first();

        if ($currencyValue === null) {
            Artisan::call('currency:daily-values-get', ['date' => $date]);
        }

        $currencyValue = CurrencyValue::query()
            ->where('code', '=', $currency->code)
            ->where('date', '=', $date)
            ->first();

        return [
            'currency' => $currency,
            'currencyValue' => $currencyValue
        ];
    }
}
