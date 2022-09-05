<?php

namespace App\Console\Commands;

use App\Models\News\Dto\NewsDto;
use App\Models\News\Enum\NewsCodeEnum;
use App\Models\News\Exception\NewsChannelNotFoundException;
use App\Models\News\Parser\NewsParserFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetLatestNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:get-latest-news {newsCode=mediaMetrics} {tag?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение последних новостей по заданному тегу';

    /**
     * Execute the console command.
     *
     * @return NewsDto[]
     * @throws NewsChannelNotFoundException
     */
    public function handle(): array
    {
        $newsCode = $this->argument('newsCode');
        $tag = $this->argument('tag');
        if ($tag === null) {
            $tag = 'Валюта';
        }

        $newsLink = $this->getNewsLinkByCode($newsCode, $tag);

        $responseData = Http::get($newsLink)
            ->toPsrResponse()
            ->getBody()
            ->getContents();

        return NewsParserFactory::make($newsCode)->parse($responseData);
    }

    private function getNewsLinkByCode(string $newsCode, string $tag = ''): string
    {
        $newsCodeEnum = NewsCodeEnum::tryFrom($newsCode);
        switch ($newsCodeEnum->getNewsCode()) {
            case NewsCodeEnum::NEWS_NOVOSTI->value:
                return env('NEWSNOVOSTI_LINK');
            case NewsCodeEnum::VESTI->value:
                return env('VESTI_FINANCE_LINK');
            case NewsCodeEnum::RIA->value:
                return env('RIA_ECONOMY_LINK');
            case NewsCodeEnum::MEDIA_METRICS->value:
            default:
                return env('NEWS_WEEK_LINK') . "{$tag}";
        }
    }
}
