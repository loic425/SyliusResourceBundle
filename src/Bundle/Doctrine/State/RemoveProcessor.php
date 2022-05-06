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

namespace Sylius\Bundle\ResourceBundle\Doctrine\State;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager as DoctrineObjectManager;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\State\ProcessorInterface;

final class RemoveProcessor implements ProcessorInterface
{
    public function __construct(private ManagerRegistry $managerRegistry)
    {
    }

    public function process(mixed $data, RequestConfiguration $configuration): void
    {
        if (!$manager = $this->getManager($data)) {
            return;
        }

        $manager->remove($data);
        $manager->flush();
    }

    /**
     * Gets the Doctrine object manager associated with given data.
     */
    private function getManager(mixed $data): ?DoctrineObjectManager
    {
        return \is_object($data) ? $this->managerRegistry->getManagerForClass($data::class) : null;
    }
}
