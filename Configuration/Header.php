<?php

namespace Nadmin\WcmBundle\Configuration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * Class Header
 *
 * @Annotation
 */
class Header extends ConfigurationAnnotation
{
    /**
     * @var array
     */
    protected $headers = [];
    /**
     * Returns the alias name for an annotated configuration.
     *
     * @return string
     */
    public function getAliasName()
    {
        return 'header';
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
     * @param $headers
     */
    public function setHeaders($headers)
    {
        $this->groups = $headers;
    }

    /**
     * @return bool
     */
    public function haveHeaders()
    {
        return !empty($this->headers);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
