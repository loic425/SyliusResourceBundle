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

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Embeddable
 *
 * @Serializer\ExclusionPolicy("all")
 */
final class Author
{
    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $lastName;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }
}
