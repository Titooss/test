<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"get","categories"}},
 *     denormalizationContext={"groups"={"categories"}},
 *     itemOperations={
 *         "get",
 *         "put"={
 *             "normalization_context"={"groups"={"categories"}}
 *         },
 *         "delete"={"path"="/categories/{id}"},
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"
 *     },
 *     subresourceOperations={
 *          "category_articles_get_subresource"={
 *              "method"="GET",
 *              "path"="/categories/{id}/articles"
 *          },
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
     * @Groups({"articles", "categories"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     * @Groups({"get", "categories"})
     * @ApiSubresource(maxDepth=1)
     * @Groups({"categories"})
     */
    private $articles;


    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->tests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);

            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }


}
