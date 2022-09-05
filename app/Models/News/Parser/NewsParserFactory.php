<?php

namespace App\Models\News\Parser;

use App\Models\News\Enum\NewsCodeEnum;
use App\Models\News\Exception\NewsChannelNotFoundException;

class NewsParserFactory
{
    /**
     * @throws NewsChannelNotFoundException
     */
    public static function make(string $newsCode): NewsParserInterface
    {
        $newsCodeEnum = NewsCodeEnum::tryFrom($newsCode);
        switch ($newsCodeEnum->getNewsCode()) {
            case NewsCodeEnum::MEDIA_METRICS->value:
                return new MediaMetricsNewsParser();
            case NewsCodeEnum::NEWS_NOVOSTI->value:
                return new NewsNovostiNewsParser();
            case NewsCodeEnum::VESTI->value:
                return new VestiNewsParser();
            case NewsCodeEnum::RIA->value:
                return new RiaNewsParser();
            default:
                throw new NewsChannelNotFoundException('Новостной канал не найден');
        }
    }
}
