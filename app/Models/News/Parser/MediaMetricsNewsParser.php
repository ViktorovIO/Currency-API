<?php

namespace App\Models\News\Parser;

use App\Models\News\Dto\NewsDto;
use PhpQuery\PhpQuery;

class MediaMetricsNewsParser implements NewsParserInterface
{
    /**
     * @param string $contentString
     * @return NewsDto[]
     */
    public function parse(string $contentString): array
    {
        $result = [];
        $phpQuery = new PhpQuery();
        $phpQuery->load_str($contentString);

        foreach ($phpQuery->query('.rs-link') as $newsItem) {
            $name = $link = '';
            $newsItemString = $phpQuery->innerHTML($newsItem);
            if (preg_match("!href=\"(.*?)\">!si", $newsItemString, $matches)) {
                $link = $matches[1];
            }

            if (preg_match("!\">(.*?)</a>!si", $newsItemString, $matches)) {
                $name = $matches[1];
            }

            $result[] = new NewsDto($name, $link);
        }

        return $result;
    }
}
