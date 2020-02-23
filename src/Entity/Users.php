<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ApiResource(
 * attributes={
 *      "formats"={"jsonld","json","csv"={"text/csv"}}
 *  }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @ApiFilter(SearchFilter::class, properties={"user":"partial","post":"partial","category":"partial"})
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Username
     *
     * @ORM\Column(type="string", length=255)
     *
     * @NotBlank()
     */
    private $user;

    /**
     * Post Title
     *
     * @ORM\Column(type="string", length=255)
     *
     * @NotBlank()
     */
    private $post;

    /**
     * User Comment
     *
     * @ORM\Column(type="text")
     *
     * @NotBlank()
     */
    private $comment;

    /**
     * Post Category. Limited to one catergoy listing
     *
     * @ORM\Column(type="string", length=255)
     *
     * @NotBlank()
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(string $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }
}
