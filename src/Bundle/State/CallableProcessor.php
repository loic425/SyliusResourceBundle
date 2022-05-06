<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\ResourceBundle\State;

use Psr\Container\ContainerInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;

final class CallableProcessor implements ProcessorInterface
{
    public function __construct(private ContainerInterface $locator)
    {
    }

    public function process(mixed $data, RequestConfiguration $configuration): mixed
    {
        $processorId = $configuration->getProcessor();

        if (null === $processorId) {
            return $data;
        }

        if (!$this->locator->has($processorId)) {
            throw new \LogicException(sprintf(
                'Processor "%s" not found on route with URI "%s" and method "%s"',
                $processorId,
                $configuration->getRequest()->getUri(),
                $configuration->getRequest()->getMethod(),
            ));
        }

        /** @var ProcessorInterface $processor */
        $processor = $this->locator->get($processorId);

        return $processor->process($data, $configuration);
    }
}
