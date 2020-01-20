<?php
declare(strict_types=1);

namespace App\Controller;

use App\Consumer\Rss;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Feed extends AbstractController
{
    /** @var Rss */
    private $consumer;

    public function __construct(Rss $consumer)
    {
        $this->consumer = $consumer;
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->consumer->read(), 200);
    }
}
