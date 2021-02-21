<?php

namespace Nadmin\WcmBundle\Entity;

use Nadmin\WcmBundle\Helper\EntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Nadmin\WcmBundle\Repository\BlockRepository")
 */
class Block
{
    use EntityTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $definition;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @var ArrayCollection
     * @ORM\Column(type="object", nullable=true)
     */
    private $fields;

    /**
     * @ORM\OneToMany(targetEntity="Nadmin\WcmBundle\Entity\TemplateBlock", mappedBy="block")
     * @ORM\JoinColumn(name="block_id", referencedColumnName="id")
     */
    private $templates;

    public function __construct()
    {
        $this->templates = new ArrayCollection();
    }

    public function getId()
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDefinition(): ?string
    {
        return $this->definition;
    }

    public function setDefinition(?string $definition): self
    {
        $this->definition = $definition;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFields(): ?array
    {
        return unserialize(base64_decode($this->fields))?:null;
    }

    public function setFields(?array $fields): self
    {
        $this->fields = base64_encode(serialize($fields));

        return $this;
    }

    /**
     * @return Collection|Template[]
     */
    public function getTemplates(): Collection
    {
        return $this->templates;
    }

    public function addTemplate(Template $template): self
    {
        if (!$this->templates->contains($template)) {
            $this->templates[] = $template;
            $template->addBlock($this);
        }

        return $this;
    }

    public function removeTemplate(Template $template): self
    {
        if ($this->templates->contains($template)) {
            $this->templates->removeElement($template);
            $template->removeBlock($this);
        }

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function timeStamp()
    {
        if (!$this->getCreatedAt())
        {
            $this->setCreatedAt(new \DateTime('now'));
        }
        $this->setUpdatedAt(new \DateTime('now'));
        foreach ($this->getTemplates() as $linkedTemplate)
        {
            $linkedTemplate->getTemplate()->timeStamp();
        }

    }
}
