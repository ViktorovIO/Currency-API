<?php

namespace App\Models\News\Parser;

use App\Models\News\Dto\NewsDto;
use PhpQuery\PhpQuery;

class VestiNewsParser implements NewsParserInterface
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

        foreach ($phpQuery->query('.list__item') as $newsItem) {
            $name = $link = $img = '';
            $newsItemString = $phpQuery->innerHTML($newsItem);
            if (preg_match("!href=\"(.*?)\">!si", $newsItemString, $matches)) {
                $link = env('VESTI_FINANCE_LINK') . $matches[1];
            }

            if (preg_match("!\">(.*?)</a>!si", $newsItemString, $matches)) {
                $name = $matches[1];
            }

            if (preg_match("!data-src=\"(.*?)\"!si", $newsItemString, $matches)) {
                $img = $matches[1];
            }

            $result[] = new NewsDto($name, $link, $img);
        }

        return $result;
    }
}
