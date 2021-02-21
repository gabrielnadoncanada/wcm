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
     * @ORM\OneToMany(targetEntity="Nadmin\WcmBundle\Entity\Page", mappedBy="template")
     */
    private $pages;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
        $this->pages = new ArrayCollection();
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
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setTemplate($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
            // set the owning side to null (unless already changed)
            if ($page->getTemplate() === $this) {
                $page->setTemplate(null);
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
