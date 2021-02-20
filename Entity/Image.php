<?php

namespace Nadmin\WcmBundle\Entity;

use Nadmin\WcmBundle\Helper\EntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Nadmin\WcmBundle\Repository\ImageRepository")
 */
class Image
{
    use EntityTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * Not registered in database.
     */
    private $fileTemp;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPrincipal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alt;
    
    /**
     * @return mixed
     */
    public function getFileTemp()
    {
        return $this->fileTemp;
    }

    /**
     * @param mixed $fileTemp
     * @return Image
     */
    public function setFileTemp($fileTemp)
    {
        $this->fileTemp = $fileTemp;
        return $this;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getIsPrincipal(): ?bool
    {
        return $this->isPrincipal;
    }

    public function setIsPrincipal(?bool $isPrincipal): self
    {
        $this->isPrincipal = $isPrincipal;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function setCreatedAt($createdAt)
    {
        if ($createdAt)
        {
            $this->createdAt = $createdAt;
        }
        return $this;
    }

    public function setUpdatedAt( $updatedAt)
    {
        if ($updatedAt)
        {
            $this->updatedAt = $updatedAt;
        }
        return $this;
    }

}
