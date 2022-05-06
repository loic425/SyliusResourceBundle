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

namespace Sylius\Bundle\ResourceBundle\Controller;

use Sylius\Bundle\ResourceBundle\State\ProcessorInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ResourceDeleteHandler implements ResourceDeleteHandlerInterface
{
    public function __construct(private ProcessorInterface $processor)
    {
    }

    public function handle(ResourceInterface $resource, /* RequestConfiguration|RepositoryInterface */$configuration): void
    {
        if ($configuration instanceof RepositoryInterface) {
            $configuration->remove($resource);

            return;
        }

        $this->processor->process($resource, $configuration);
    }
}
