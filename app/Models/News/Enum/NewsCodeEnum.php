<?php

namespace App\Models\News\Enum;

enum NewsCodeEnum: string
{
    case MEDIA_METRICS = 'mediaMetrics';
    case NEWS_NOVOSTI = 'newsNovosti';
    case VESTI = 'vesti';
    case RIA = 'ria';

    public function getNewsCode(): string
    {
        return match($this)
        {
            self::MEDIA_METRICS => 'mediaMetrics',
            self::NEWS_NOVOSTI => 'newsNovosti',
            self::VESTI => 'vesti',
            self::RIA => 'ria',
        };
    }
}
