<?php
declare(strict_types=1);

namespace App\Consumer;

use FeedIo\{Feed, FeedIo};
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final class Rss implements Consumer
{
    /** @var FeedIo */
    private $feedIo;

    /** @var ContainerBagInterface */
    private $parameterBag;

    public function __construct(FeedIo $feedIo, ContainerBagInterface $parameterBag)
    {
        $this->feedIo = $feedIo;
        $this->parameterBag = $parameterBag;
    }

    public function read(): array
    {
        $items = [];
        $modifiedSince = new \DateTime();
        $modifiedSince->setTime(0, 0);

        $urlCollection = $this->parameterBag->get('rss.url_collection');

        foreach ($urlCollection as $url) {
            $feed = $this->feedIo->read($url, new Feed(), $modifiedSince)->getFeed();

            foreach ($feed as $item) {
                $items[$feed->getTitle()][] = $item->getTitle() . PHP_EOL;
            }
        }

        return $items;
    }
}
