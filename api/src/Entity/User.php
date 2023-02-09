<?php

namespace App\Entity;

use App\Entity\Traits\BlameTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\Interfaces\BlameInterface;
use App\Entity\Traits\Interfaces\IdentifierInterface;
use App\Entity\Traits\Interfaces\TimestampInterface;
use App\Entity\Traits\TimestampTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Generator;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method string getUserIdentifier()
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
class User implements IdentifierInterface, TimestampInterface, BlameInterface, UserInterface
{
    use IdentifierTrait {
        IdentifierTrait::__construct as private __identifierConstruct;
    }
    use TimestampTrait;
    use BlameTrait;
    private const JWT_HASH_VALUE = '12345678901234567890123456789012';
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $googleId = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $facebookId = null;

    #[ORM\Column(length: 2048, unique: true)]
    private ?string $apiToken = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $birthDate = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Article::class)]
    private Collection $articles;

    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'users')]
    private ?Address $address;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->__identifierConstruct();
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function setName(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeImmutable $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getApiToken(): string
    {
        return $this->apiToken;
    }

    /**
     * @throws SigningException
     * @throws JsonEncodingException
     */
    public function setApiToken(string $socialNetworkToken): self
    {
        $this->apiToken = (new Generator(new HS256(self::JWT_HASH_VALUE)))->generate(
            [
                'id' => $this->getId(),
                'email' => $this->getEmail(),
                'token' => $socialNetworkToken
            ]
        );

        return $this;
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }
    public function setGoogleId(?string $googleId): self
    {
        $this->googleId = $googleId;

        return $this;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(?string $facebookId): self
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername(): string
    {
        return $this->email;
    }
}
