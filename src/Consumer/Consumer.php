<?php
declare(strict_types=1);

namespace App\Consumer;

interface Consumer
{
    public function read(): array;
}
