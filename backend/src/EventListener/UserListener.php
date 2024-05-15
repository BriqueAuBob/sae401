<?php

namespace App\EventListener;

use App\Entity\Preference;
use App\Event\UserCreateEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class UserListener
{
    private $defaultPreferences = [
        [
            'pkey' => 'temp_unit',
            'pvalue' => 'celsius',
        ],
        [
            'pkey' => 'cities',
            'pvalue' => ['Paris', 'Troyes', 'Marseille'],
        ]
    ];

    public function __construct(private EntityManagerInterface $entityManager) {}

    #[AsEventListener(event: UserCreateEvent::NAME)]
    public function onUserCreate(UserCreateEvent $event): void
    {
        foreach($this->defaultPreferences as $preference) {
            $p = new Preference();
            $p->setUser($event->getUser());
            $p->setPkey($preference['pkey']);
            $p->setPvalue($preference['pvalue']);
            $this->entityManager->persist($p);
        }
        $this->entityManager->flush();
    }
}
