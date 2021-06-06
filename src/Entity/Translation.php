<?php

namespace App\Entity;

use App\Repository\TranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass=TranslationRepository::class)
 * @ORM\Table(uniqueConstraints={@UniqueConstraint(name="lang_key", columns={"language_id","key"})})
 */
class Translation
{
    /**
     * @JMS\Type("int")
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @JMS\Exclude()
     *
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="translations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @JMS\Type("string")
     * @ORM\Column(type="string", name="`key`", length=255)
     *
	 * @var string
     */
    private $key;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
