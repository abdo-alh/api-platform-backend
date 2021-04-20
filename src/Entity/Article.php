<?php

namespace App\Entity;

use App\Entity\ArticleUpdatedAt;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *        "get"={
 *             "normalization_context"={"groups"={"article_read"}}
 *         },
 *         "post"
 *     },
 *     itemOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"article_details_read"}}
 *         },
 *         "put",
 *         "patch",
 *         "delete",
 *         "put_updated_at"={
 *             "method"="PUT",
 *             "path"="/articles/{id}/updated-at",
 *             "controller"=ArticleUpdatedAt::class,
 *         }
 *     }
 * )
 */
class Article
{
    use Timesampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"article_read","user_details_read","article_details_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"article_read","user_details_read","article_details_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"article_read","user_details_read","article_details_read"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @Groups({"article_details_read"})
     */
    private $author;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
