<?php

namespace Nadmin\WcmBundle\Configuration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * Class Json
 *
 * @Annotation
 */
class Json extends ConfigurationAnnotation
{

    /**
     * @var bool
     */
    protected $serializable = false;

    /**
     * @var array
     */
    protected $groups = [];
    /**
     * Returns the alias name for an annotated configuration.
     *
     * @return string
     */
    public function getAliasName()
    {
        return 'json';
    }

    /**
     * Returns whether multiple annotations of this type are allowed
     *
     * @return Boolean
     */
    public function allowArray()
    {
        return false;
    }

    /**
     * @param bool $serializable
     *
     * @return $this
     */
    public function setSerializable($serializable)
    {
        $this->serializable = $serializable;
    }

    /**
     * @return array
     */
    public function isSerializable()
    {
        return $this->serializable;
    }

    /**
     * @param $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    public function haveGroups()
    {
        return !empty($this->groups);
    }

    public function getGroups()
    {
        return $this->groups;
    }
}
