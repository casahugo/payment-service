<?php

declare(strict_types=1);

namespace App\Gateway\Action;

interface ActionInterface
{
    public function execute($request);

    public function supports($request, string $class): bool;
}
