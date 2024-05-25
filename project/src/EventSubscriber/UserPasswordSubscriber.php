<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Symfony\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordSubscriber implements EventSubscriberInterface
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['hashPassword',EventPriorities::PRE_WRITE],
        ];
    }
    public function hashPassword(ViewEvent $event): void
    {
        $user = $event->getControllerResult();
        $methode = $event ->getRequest()->getMethod();

        if ($user instanceof User && $methode === Request::METHOD_POST && $methode === Request::METHOD_PUT) {
            $user -> setPassword($this-> passwordHasher -> hashPassword($user, $user->getPassword()));
        }
    }
}