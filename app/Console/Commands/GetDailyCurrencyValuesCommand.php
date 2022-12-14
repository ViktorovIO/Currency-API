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
    protected $signature = 'currency:daily-values-get {date?}';

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
        $dateString = $this->argument('date');
        if ($dateString === null) {
            $dateString = date('Y-m-d');
        }

        $date = Carbon::createFromFormat('Y-m-d', $dateString)->format('d/m/Y');
        $link = env('CURRENCY_DAILY_DUMP_LINK') . "?date_req={$date}";
        $response = Http::get($link);

        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        collect($array['Valute'])
            ->map(function (array $valute) use ($dateString): void {
                $currencyDto = $this->makeCurrencyDto($valute);

                $this->checkCurrency($currencyDto);
                $this->saveCurrencyValue($currencyDto, $dateString);
            });

        return 0;
    }

    private function makeCurrencyDto(array $valute): CurrencyDto
    {
        $charCode = (string) $valute['CharCode'];
        $currencyNameEnum = CurrencyNameEnum::tryFrom($charCode);
        $currencyValue = str_replace(',', '.', (string) $valute['Value']);

        return new CurrencyDto(
            (string) $valute['NumCode'],
            $charCode,
            $valute['Nominal'],
            $currencyNameEnum->getNameSingle(),
            $currencyNameEnum->getNameMany(),
            $currencyValue
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

    private function saveCurrencyValue(CurrencyDto $currencyDto, string $dateString): void
    {
        $currencyValue = CurrencyValue::query()
            ->where('code', $currencyDto->getNumCode())
            ->where('date', $dateString)
            ->first();

        if ($currencyValue === null) {
            CurrencyValue::query()->create([
                'code' => $currencyDto->getNumCode(),
                'date' => $dateString,
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
