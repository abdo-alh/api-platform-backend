<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTCreatedListener
{
    /** @var User */
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        if (null !== $this->user) {
            $payload = $event->getData();
            $payload['createdAt'] = $this->user->getCreatedAt();
            $event->setData($payload);
        }
    }
}
