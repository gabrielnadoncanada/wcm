<?php

namespace Nadmin\WcmBundle\Entity;

use Nadmin\WcmBundle\Helper\EntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Nadmin\WcmBundle\Repository\TemplateRepository")
 */
class Template
{
    use EntityTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $structure;

    /**
     * @ORM\OneToMany(targetEntity="Nadmin\WcmBundle\Entity\TemplateBlock", mappedBy="template", cascade={"remove"})
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id")
     */
    private $blocks;

    /**
     * @ORM\OneToMany(targetEntity="Nadmin\WcmBundle\Entity\Node", mappedBy="template")
     */
    private $nodes;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
        $this->nodes = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * @param mixed $structure
     * @return Template
     */
    public function setStructure($structure)
    {
        $this->structure = $structure;
        return $this;
    }

    public function explodeStructure()
    {
        return json_decode($this->structure, true);
    }

    /**
     * @return Collection|Block[]
     */
    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function addBlock(Block $block): self
    {
        if (!$this->blocks->contains($block)) {
            $this->blocks[] = $block;
        }

        return $this;
    }

    public function removeBlock(Block $block): self
    {
        if ($this->blocks->contains($block)) {
            $this->blocks->removeElement($block);
        }

        return $this;
    }

    /**
     * @return Collection|Node[]
     */
    public function getPages(): Collection
    {
        return $this->nodes;
    }

    public function addPage(Node $node): self
    {
        if (!$this->nodes->contains($node)) {
            $this->nodes[] = $node;
            $node->setTemplate($this);
        }

        return $this;
    }

    public function removePage(Node $node): self
    {
        if ($this->nodes->contains($node)) {
            $this->nodes->removeElement($node);
            // set the owning side to null (unless already changed)
            if ($node->getTemplate() === $this) {
                $node->setTemplate(null);
            }
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
        foreach ($this->getPages() as $linkedPage)
        {
            $linkedPage->setUpdatedAt(new \DateTime('now'));
        }
    }
}
