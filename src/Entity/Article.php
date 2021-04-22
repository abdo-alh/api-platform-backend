<?php

namespace App\Entity;

use DateTime;
use Carbon\Carbon;
use App\Entity\User;
use DateTimeInterface;
use App\Entity\ArticleUpdatedAt;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use App\Controller\PostCountController;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

//for disable the api "openapi_context"={"summary"="hidden"},"read"=false,"output"=false
/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *        "get"={
 *             "normalization_context"={"groups"={"article_read"},"openapi_definition_name"="Collection"}
 *         },
 *         "post",
 *         "count"={
 *             "method"="GET",
 *             "path"="/articles/count",
 *             "controller"=PostCountController::class,
 *             "pagination_enabled"=false,
 *             "filters"={},
 *             "openapi_context"={
 *                 "summary"="Permet d'afficher le nombre des articles",
 *                 "parameters"={},
 *                 "requestBody"={
 *                      "content"={
 *                          "application/json"={
 *                              "schema"={
 *                              }
 *                          }
 *                      }
 *                 }
 *             }
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"article_details_read"}, "openapi_definition_name"="Detail"},
 *         },
 *         "put",
 *         "patch",
 *         "delete",
 *         "put_updated_at"={
 *             "method"="PUT",
 *             "path"="/articles/{id}/updated-at",
 *             "controller"=ArticleUpdatedAt::class,
 *         },
 *         "publish"={
 *             "method"="POST",
 *             "path"="/articles/{id}/publish",
 *             "controller"=ArticleUpdatedAt::class,
 *             "openapi_context"={
 *                 "summary"="Permet de publier un article",
 *                 "requestBody"={
 *                      "content"={
 *                          "application/json"={
 *                              "schema"={
 *                              }
 *                          }
 *                      }
 *                 }
 *             }
 *         }
 *     },
 *     paginationItemsPerPage=2,
 *     paginationMaximumItemsPerPage=2
 * )
 */
class Article
{

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
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="string"
     *         }
     *     }
     * )
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

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"article_read","user_details_read","article_details_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"article_read","user_details_read","article_details_read"})
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @Groups({"article_read","user_details_read","article_details_read"})
     */
    public function getCreatedAtAgo():string
    {
        return Carbon::instance($this->getCreatedAt())->diffForHumans();
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
