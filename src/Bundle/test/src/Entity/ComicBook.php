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
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_comic_book")
 * @ORM\MappedSuperclass
 *
 * @Serializer\ExclusionPolicy("all")
 */
class ComicBook implements ResourceInterface
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\XmlAttribute("true")
     */
    private $id;

    /**
     * @var Author
     *
     * @ORM\Embedded(class="App\Entity\Author")
     *
     * @Serializer\Expose
     * @Serializer\Since("0.x")
     * @Serializer\Until("1.1")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $title;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("author_first_name")
     * @Serializer\Since("1.1")
     */
    public function getAuthorFirstName(): ?string
    {
        return $this->author ? $this->author->getFirstName() : null;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("author_last_name")
     * @Serializer\Since("1.1")
     */
    public function getAuthorLastName(): ?string
    {
        return $this->author ? $this->author->getLastName() : null;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): void
    {
        $this->author = $author;
    }
}
