<?php

namespace App\Console\Commands;

use App\Models\Dto\NewsDto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use PhpQuery\PhpQuery;

class GetLatestNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:get-latest-news {tag?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение последних новостей по заданному тегу';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tag = $this->argument('tag');
        if ($tag === null) {
            $tag = 'Валюта';
        }

        # @TODO - парсить по этой ссылке с тегом
        $link = env('NEWS_WEEK_LINK') . "{$tag}";

        $responseData = Http::get(env('NEWSNOVOSTI_LINK'))
            ->toPsrResponse()
            ->getBody()
            ->getContents();

        $news = $this->parseNewsString($responseData);

        return 0;
    }

    private function parseNewsString(string $contentString): array
    {
        $result = [];
        $phpQuery = new PhpQuery();
        $phpQuery->load_str($contentString);

        foreach ($phpQuery->query('.feed-item') as $newsItem) {
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
