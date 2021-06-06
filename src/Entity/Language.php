<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 * @ORM\Table(uniqueConstraints={@UniqueConstraint(name="name", columns={"name"})})
 */
class Language
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 *
	 * @var int
	 */
	private $id;

	/**
	 * @JMS\Type("string")
	 * @ORM\Column(type="string")
	 *
	 * @var string
	 */
	private $name;

	/**
	 * @JMS\Exclude()
	 * @ORM\OneToMany(targetEntity=Translation::class, mappedBy="language", orphanRemoval=true)
	 */
	private $translations;

	public function __construct()
	{
		$this->translations = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return $this
	 */
	public function setName(string $name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return Collection|Translation[]
	 */
	public function getTranslations(): Collection
	{
		return $this->translations;
	}

	public function addTranslation(Translation $translation): self
	{
		if (!$this->translations->contains($translation)) {
			$this->translations[] = $translation;
			$translation->setLanguage($this);
		}

		return $this;
	}

	public function removeTranslation(Translation $translation): self
	{
		if ($this->translations->removeElement($translation)) {
			// set the owning side to null (unless already changed)
			if ($translation->getLanguage() === $this) {
				$translation->setLanguage(null);
			}
		}

		return $this;
	}
}
