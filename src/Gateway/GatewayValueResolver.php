<?php

declare(strict_types=1);

namespace App\Gateway;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class GatewayValueResolver implements ArgumentValueResolverInterface
{
    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return GatewayInterface::class === $argument->getType() &&
            $this->container->has($request->attributes->get('gatewayName'));
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        return yield $this->container->get($request->attributes->get('gatewayName'));
    }
}
