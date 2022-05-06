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

use Doctrine\Persistence\ObjectManager;
use Sylius\Bundle\ResourceBundle\State\ProcessorInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

final class ResourceUpdateHandler implements ResourceUpdateHandlerInterface
{
    public function __construct(
        private ProcessorInterface $processor,
        private ?StateMachineInterface $stateMachine
    ) {
    }

    public function handle(
        ResourceInterface $resource,
        RequestConfiguration $requestConfiguration,
        ObjectManager $manager
    ): void {
        if (null !== $this->stateMachine && $requestConfiguration->hasStateMachine()) {
            $this->stateMachine->apply($requestConfiguration, $resource);
        }

        $this->processor->process($resource, $requestConfiguration);
    }
}
