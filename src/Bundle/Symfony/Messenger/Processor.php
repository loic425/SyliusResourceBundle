<?php

declare(strict_types=1);

namespace Sylius\Bundle\ResourceBundle\Symfony\Messenger;

use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\State\ProcessorInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class Processor implements ProcessorInterface
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function process(mixed $data, RequestConfiguration $configuration): mixed
    {
        $this->messageBus->dispatch(
            new Envelope($data)
        );

        return $data;
    }
}
