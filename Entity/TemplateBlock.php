<?php

namespace Nadmin\WcmBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Nadmin\WcmBundle\Repository\TemplateBlockRepository")
 */
class TemplateBlock
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Nadmin\WcmBundle\Entity\Template", inversedBy="blocks")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id")
     */
    private $template;

    /**
     * @ORM\ManyToOne(targetEntity="Nadmin\WcmBundle\Entity\Block")
     * @ORM\JoinColumn(name="block_id", referencedColumnName="id")
     */
    private $block;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return TemplateBlock
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     * @return TemplateBlock
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param mixed $block
     * @return TemplateBlock
     */
    public function setBlock($block)
    {
        $this->block = $block;
        return $this;
    }


}
