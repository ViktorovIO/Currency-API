<?php

namespace App\Models\Enum;

enum CurrencyNameEnum: string
{
    case AUD = 'AUD';
    case AZN = 'AZN';
    case GBP = 'GBP';
    case AMD = 'AMD';
    case BYN = 'BYN';
    case BGN = 'BGN';
    case BRL = 'BRL';
    case HUF = 'HUF';
    case HKD = 'HKD';
    case DKK = 'DKK';
    case USD = 'USD';
    case EUR = 'EUR';
    case INR = 'INR';
    case KZT = 'KZT';
    case CAD = 'CAD';
    case KGS = 'KGS';
    case CNY = 'CNY';
    case MDL = 'MDL';
    case NOK = 'NOK';
    case PLN = 'PLN';
    case RON = 'RON';
    case XDR = 'XDR';
    case SGD = 'SGD';
    case TJS = 'TJS';
    case TRY = 'TRY';
    case TMT = 'TMT';
    case UZS = 'UZS';
    case UAH = 'UAH';
    case CZK = 'CZK';
    case SEK = 'SEK';
    case CHF = 'CHF';
    case ZAR = 'ZAR';
    case KRW = 'KRW';
    case JPY = 'JPY';

    public function getNameSingle(): string
    {
        return match($this)
        {
            self::AUD => 'Австралийский доллар',
            self::AZN => 'Азербайджанский манат',
            self::GBP => 'Фунт стерлингов Соединенного королевства',
            self::AMD => 'Армянский драм',
            self::BYN => 'Белорусский рубль',
            self::BGN => 'Болгарский лев',
            self::BRL => 'Бразильский реал',
            self::HUF => 'Венгерский форинт',
            self::HKD => 'Гонконгский доллар',
            self::DKK => 'Датская крона',
            self::USD => 'Доллар США',
            self::EUR => 'Евро',
            self::INR => 'Индийский рупий',
            self::KZT => 'Казахстанский тенге',
            self::CAD => 'Канадский доллар',
            self::KGS => 'Киргизский сом',
            self::CNY => 'Китайский юань',
            self::MDL => 'Молдавский леев',
            self::NOK => 'Норвежская крона',
            self::PLN => 'Польский злотый',
            self::RON => 'Румынский лей',
            self::XDR => 'СДР (специальные права заимствования)',
            self::SGD => 'Сингапурский доллар',
            self::TJS => 'Таджикский сомони',
            self::TRY => 'Турецкая лира',
            self::TMT => 'Новый туркменский манат',
            self::UZS => 'Узбекская сума',
            self::UAH => 'Украинская гривна',
            self::CZK => 'Чешская крона',
            self::SEK => 'Шведская крона',
            self::CHF => 'Швейцарский франк',
            self::ZAR => 'Южноафриканский рэнд',
            self::KRW => 'Вон Республики Корея',
            self::JPY => 'Японская иена',
        };
    }

    public function getNameMany(): string
    {
        return match($this)
        {
            self::AUD => 'Австралийских долларов',
            self::AZN => 'Азербайджанских манат',
            self::GBP => 'Фунтов стерлингов Соединенного королевства',
            self::AMD => 'Армянских драмов',
            self::BYN => 'Белорусских рублей',
            self::BGN => 'Болгарских левов',
            self::BRL => 'Бразильских реалов',
            self::HUF => 'Венгерских форинтов',
            self::HKD => 'Гонконгских долларов',
            self::DKK => 'Датских крон',
            self::USD => 'Долларов США',
            self::EUR => 'Евро',
            self::INR => 'Индийских рупий',
            self::KZT => 'Казахстанских тенге',
            self::CAD => 'Канадских долларов',
            self::KGS => 'Киргизский сомов',
            self::CNY => 'Китайских юаней',
            self::MDL => 'Молдавских леев',
            self::NOK => 'Норвежских крона',
            self::PLN => 'Польских злотых',
            self::RON => 'Румынских лей',
            self::XDR => 'СДР (специальные права заимствования)',
            self::SGD => 'Сингапурских долларов',
            self::TJS => 'Таджикских сомони',
            self::TRY => 'Турецких лир',
            self::TMT => 'Новых туркменских манат',
            self::UZS => 'Узбекских сумов',
            self::UAH => 'Украинских гривен',
            self::CZK => 'Чешских крон',
            self::SEK => 'Шведских крон',
            self::CHF => 'Швейцарских франков',
            self::ZAR => 'Южноафриканских рэндов',
            self::KRW => 'Вон Республики Корея',
            self::JPY => 'Японских иен',
        };
    }
}
