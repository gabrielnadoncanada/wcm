<?php

namespace Nadmin\WcmBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Nadmin\WcmBundle\Entity\User;

class WcmLastLoginListener
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        // Get the User entity.
        $user = $event->getAuthenticationToken()->getUser();

        // Update your field here.
        $user->setLastLoginAt(new \DateTime());

        // Persist the data to database.
        $this->em->persist($user);
        $this->em->flush();
    }
}
