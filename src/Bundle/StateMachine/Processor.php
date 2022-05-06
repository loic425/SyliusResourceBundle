<?php

declare(strict_types=1);

namespace Sylius\Bundle\ResourceBundle\StateMachine;

use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\Controller\StateMachineInterface;
use Sylius\Bundle\ResourceBundle\State\ProcessorInterface;

final class Processor implements ProcessorInterface
{
    public function __construct(private StateMachineInterface $stateMachine)
    {
    }

    public function process(mixed $data, RequestConfiguration $configuration): mixed
    {
        if (!$configuration->hasStateMachine()) {
           return $data;
        }

        $this->stateMachine->apply($configuration, $data);

        return $data;
    }
}
