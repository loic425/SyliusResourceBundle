<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Resource\Symfony\WebLink\State;

use Psr\Link\EvolvableLinkInterface;
use Sylius\Resource\Context\Context;
use Sylius\Resource\Context\Option\RequestOption;
use Sylius\Resource\Metadata\Operation;
use Sylius\Resource\State\ProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\WebLink\HttpHeaderSerializer;
use Symfony\Component\WebLink\Link;

final class SendEarlyHintsProvider implements ProviderInterface
{
    public function __construct(
        private ProviderInterface $provider,
        private ?HttpHeaderSerializer $serializer = null,
    ) {
    }

    public function provide(Operation $operation, Context $context): object|array|null
    {
        $data = $this->provider->provide($operation, $context);

        $request = $context->get(RequestOption::class)?->request();

        if (null === $request) {
            return $data;
        }

        if (null === $this->serializer) {
            throw new \LogicException('You cannot use the "sendEarlyHints" method if the WebLink component is not available. Try running "composer require symfony/web-link".');
        }

        /** @var Response $response */
        $response = $request->attributes->get('response') ?? new Response();

        $links = [
            new Link(rel: 'preconnect', href: 'https://fonts.google.com'),
        ];

        $populatedLinks = [];
        foreach ($links as $link) {
            if ($link instanceof EvolvableLinkInterface && !$link->getRels()) {
                $link = $link->withRel('preload');
            }

            $populatedLinks[] = $link;
        }

        $response->headers->set('Link', $this->serializer->serialize($populatedLinks), false);
        $response->sendHeaders(103);

        $request->attributes->set('response', $response);

        return $data;
    }
}
