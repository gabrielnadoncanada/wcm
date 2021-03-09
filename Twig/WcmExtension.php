<?php

namespace Nadmin\WcmBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class WcmExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('ed', [$this, 'editable']),
        ];
    }

    public function editable($content)
    {
        return $content;
    }
}
