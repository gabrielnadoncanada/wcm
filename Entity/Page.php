<?php

namespace Nadmin\WcmBundle\Entity;

use Nadmin\WcmBundle\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $locale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Template::class, cascade={"persist", "remove"})
     */
    private $template;

//    /**
//     * @ORM\Column(type="string", length=255)
//     */
//    private $menu;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

//    public function getMenu(): ?string
//    {
//        return $this->menu;
//    }
//
//    public function setMenu(string $menu): self
//    {
//        $this->menu = $menu;
//
//        return $this;
//    }

public function getSlug(): ?string
{
    return $this->slug;
}

public function setSlug(string $slug): self
{
    $this->slug = $slug;

    return $this;
}

public function getTemplate(): ?template
{
    return $this->template;
}

public function setTemplate(?template $template): self
{
    $this->template = $template;

    return $this;
}
}
