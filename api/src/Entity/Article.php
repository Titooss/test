<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ApiResource(
 *     attributes={"pagination_client_enabled"=true, "pagination_items_per_page"=30, "filters"={"offer.date_filter"}},
 *     normalizationContext={"groups"={"articles"}},
 *     itemOperations={
 *         "get"={"path"="/articles/{id}", "requirements"={"id"="\d+"}},
 *         "put"={"path"="/articles/{id}", "requirements"={"id"="\d+"}},
 *         "delete"={"path"="articles/{id}", "requirements"={"id"="\d+"}}
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"={"security"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"categories": "start"})
 * @ApiFilter(OrderFilter::class, properties={"dateCreated": "ASC"})
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 *
 * *
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"articles", "categories"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"articles", "categories"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Groups({"articles", "categories"})
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull
     * @Groups({"articles"})
     */
    private $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles")
     * @Assert\NotNull
     * @Groups({"articles"})
     */
    private $category;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->dateCreated = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

}
