<?php
/**
 * Created by PhpStorm.
 * User: presleylupon
 * Date: 26/07/2018
 * Time: 12:49
 */

namespace App\Subscriber;


use App\Event\UserRegisteredEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisteredEvent::NAME => 'onUserRegisteredEvent',
        ];

    }

    public function onUserRegisteredEvent(UserRegisteredEvent $userRegisteredEvent)
    {
        $user = $userRegisteredEvent->getUser();
        $this->logger->info('user register', ['email'=> $user->getEmail()]);
    }

}