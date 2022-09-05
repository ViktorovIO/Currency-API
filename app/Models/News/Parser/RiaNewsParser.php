<?php

namespace App\Models\News\Parser;

use App\Models\News\Dto\NewsDto;

class RiaNewsParser implements NewsParserInterface
{
    /**
     * @param string $contentString
     * @return NewsDto[]
     */
    public function parse(string $contentString): array
    {
        return [];
    }
}
