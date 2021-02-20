<?php

namespace Nadmin\WcmBundle\EventSubscriber;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->hasPreviousSession()) {
            return;
        }

        if ($locale = $request->query->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        } else {
            // if no explicit locale has been set on this request, use one from the session
            if (!$request->getSession()->get('_locale', false)) {
                $request->getSession()->set('_locale', $this->defaultLocale);
            }
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 20)),
        );
    }
}
