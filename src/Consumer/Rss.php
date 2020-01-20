<?php
declare(strict_types=1);

namespace App\Consumer;

use FeedIo\Feed;
use \FeedIo\FeedIo;

final class Rss implements Consumer
{
    /** @var FeedIo */
    private $feedIo;

    private const URL_COLLECTION = [
        'https://g1.globo.com/rss/g1/ciencia-e-saude/',
        'https://g1.globo.com/rss/g1/mundo/',
        'https://g1.globo.com/rss/g1/planeta-bizarro/',
        'https://g1.globo.com/rss/g1/tecnologia/',
        'https://g1.globo.com/rss/g1/turismo-e-viagem/',
        'https://g1.globo.com/rss/g1/distrito-federal/',
        'https://gizmodo.uol.com.br/feed/',
    ];

    public function __construct(FeedIo $feedIo)
    {
        $this->feedIo = $feedIo;
    }

    public function read(): array
    {
        $items = [];
        $modifiedSince = new \DateTime();
        $modifiedSince->setTime(0, 0);

        foreach (self::URL_COLLECTION as $url) {
            $feed = $this->feedIo->read($url, new Feed(), $modifiedSince)->getFeed();

            foreach ($feed as $item) {
                $items[$feed->getTitle()][] = $item->getTitle() . PHP_EOL;
            }
        }

        return $items;
    }
}
