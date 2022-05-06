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

final class ResourceCreateHandler implements ResourceCreateHandlerInterface
{
    public function __construct(
        private ProcessorInterface $processor,
        private ?StateMachineInterface $stateMachine,
    ) {
    }

    public function handle(ResourceInterface $resource, RequestConfiguration $configuration): void
    {
        if ($configuration->hasStateMachine()) {
            $stateMachine = $this->getStateMachine();
            $stateMachine->apply($configuration, $resource);
        }

        $this->processor->process($resource, $configuration);
    }

    private function getStateMachine(): StateMachineInterface
    {
        if (null === $this->stateMachine) {
            throw new \LogicException('You can not use the "state-machine" if Winzou State Machine Bundle or Symfony Workflow is not available. Try running "composer require winzou/state-machine-bundle" or "composer require symfony/workflow".');
        }

        return $this->stateMachine;
    }
}
