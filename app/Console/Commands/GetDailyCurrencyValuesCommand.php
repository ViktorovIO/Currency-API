<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\CurrencyValue;
use App\Models\Dto\CurrencyDto;
use App\Models\Enum\CurrencyNameEnum;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetDailyCurrencyValuesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:daily-values-get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение ежедневно обновляемого списка значений зарубежных валют';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get(env('CURRENCY_DAILY_DUMP_LINK'));
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        collect($array['Valute'])
            ->map(function (array $valute): void {
                $currencyDto = $this->makeCurrencyDto($valute);

                $this->checkCurrency($currencyDto);
                $this->saveCurrencyValue($currencyDto);
            });

        return 0;
    }

    private function makeCurrencyDto(array $valute): CurrencyDto
    {
        $charCode = (string) $valute['CharCode'];
        $currencyNameEnum = CurrencyNameEnum::tryFrom($charCode);

        return new CurrencyDto(
            (string) $valute['NumCode'],
            $charCode,
            $valute['Nominal'],
            $currencyNameEnum->getNameSingle(),
            $currencyNameEnum->getNameMany(),
            (float) $valute['Value']
        );
    }

    private function checkCurrency(CurrencyDto $currencyDto): void
    {
        $currency = Currency::query()->where('code', $currencyDto->getNumCode())->first();

        if ($currency === null) {
            Currency::query()->create([
                'code' => $currencyDto->getNumCode(),
                'char_code' => $currencyDto->getCharCode(),
                'name_single' => $currencyDto->getNameSingle(),
                'name_many' => $currencyDto->getNameMany(),
            ]);
        }
    }

    private function saveCurrencyValue(CurrencyDto $currencyDto): void
    {
        $today = Carbon::now()->format('Y-m-d');
        $currencyValue = CurrencyValue::query()
            ->where('code', $currencyDto->getNumCode())
            ->where('date', $today)
            ->first();

        if ($currencyValue === null) {
            CurrencyValue::query()->create([
                'code' => $currencyDto->getNumCode(),
                'date' => $today,
                'value' => $currencyDto->getValue(),
                'nominal' => $currencyDto->getNominal(),
            ]);
        } else {
            CurrencyValue::query()->update([
                'value' => $currencyDto->getValue(),
                'nominal' => $currencyDto->getNominal(),
            ]);
        }
    }
}
