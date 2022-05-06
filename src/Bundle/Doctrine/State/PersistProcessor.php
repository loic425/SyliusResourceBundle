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

use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager as DoctrineObjectManager;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\State\ProcessorInterface;

final class PersistProcessor implements ProcessorInterface
{
    public function __construct(private ManagerRegistry $managerRegistry)
    {
    }

    public function process(mixed $data, RequestConfiguration $configuration): void
    {
        if (!$manager = $this->getManager($data)) {
            return;
        }

        if (!$manager->contains($data) || $this->isDeferredExplicit($manager, $data)) {
            $manager->persist($data);
        }

        $manager->flush();
        $manager->refresh($data);
    }

    /**
     * Gets the Doctrine object manager associated with given data.
     */
    private function getManager(mixed $data): ?DoctrineObjectManager
    {
        return \is_object($data) ? $this->managerRegistry->getManagerForClass($data::class) : null;
    }

    /**
     * Checks if doctrine does not manage data automatically.
     */
    private function isDeferredExplicit(DoctrineObjectManager $manager, mixed $data): bool
    {
        $classMetadata = $manager->getClassMetadata($data::class);
        if (
            ($classMetadata instanceof ClassMetadataInfo || $classMetadata instanceof ClassMetadata)
            && method_exists($classMetadata, 'isChangeTrackingDeferredExplicit')
        ) {
            return $classMetadata->isChangeTrackingDeferredExplicit();
        }

        return false;
    }
}
