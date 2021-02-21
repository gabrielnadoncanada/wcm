<?php

namespace Nadmin\WcmBundle\Model;

class Field
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $attr;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var mixed
     */
    private $placeholder;

    public function __construct()
    {
        $this->identifier = $this->slugify($this->name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Field
     */
    public function setName(string $name)
    {
        $this->name = $name;
        $this->identifier = $this->slugify($name);
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Field
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Field
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }
    /**
     * @return string
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * @param string $attr
     * @return Field
     */
    public function setAttr(string $attr = null)
    {
        $this->attr = $attr;
        return $this;
    }
    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return Field
     */
    public function setTag(string $tag)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Field
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param mixed $placeholder
     * @return Field
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->slugify($this->getName());
    }


    /**
     * Transform (e.g. "Hello World") into a slug (e.g. "hello-world").
     *
     * @param string $string
     *
     * @return string
     */
    public function slugify($string)
    {
        $rule = 'NFD; [:Nonspacing Mark:] Remove; NFC';
        $transliterator = \Transliterator::create($rule);
        $string = $transliterator->transliterate($string);

        return preg_replace(
            '/[^a-z0-9]/',
            '-',
            strtolower(trim(strip_tags($string)))
        );
    }
}
