<?php
namespace Nadmin\WcmBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class HeaderListener
 * @package Nadmin\WcmBundle\EventListener
 */
class HeaderListener
{
    /**
     * Renders the JSON-encoded data returned by the controller.
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if ($configuration = $event->getRequest()->attributes->get('_header')) {
            foreach($configuration->getHeaders() as $property => $value) {
                $event->getResponse()->headers->set($property, $value);
            }
        }

    }
}
