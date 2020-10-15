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

namespace Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler;

use SM\StateMachine\StateMachineInterface;
use Sylius\Bundle\ResourceBundle\Controller\StateMachine;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterStateMachinePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!class_exists(StateMachineInterface::class)) {
            return;
        }

        $stateMachineDefinition = $container->register('sylius.resource_controller.state_machine', StateMachine::class);
        $stateMachineDefinition->setPublic(false);
        $stateMachineDefinition->addArgument(new Reference('sm.factory'));
    }
}
