<?php

namespace App\EventListener;

use App\Entity\Preference;
use App\Event\UserCreateEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class UserListener
{
    const DEFAULT_PREFERENCES = [
        [
            'pkey' => 'temp_unit',
            'pvalue' => 'celsius',
        ],
        [
            'pkey' => 'cities',
            'pvalue' => ['Paris', 'Troyes', 'Marseille'],
        ],
        [
            'pkey' => 'display_min_max',
            'pvalue' => true
        ],
        [
            'pkey' => 'wind_speed_unit',
            'pvalue' => 'kmph'
        ],
        [
            'pkey' => 'display_wind',
            'pvalue' => true
        ],
        [
            'pkey' => 'display_sun_phases',
            'pvalue' => true
        ],
        [
            'pkey' => 'display_humidity',
            'pvalue' => true
        ],
        [
            'pkey' => 'display_clouds',
            'pvalue' => true
        ],
        [
            'pkey' => 'display_pressure',
            'pvalue' => true
        ]
    ];

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[AsEventListener(event: UserCreateEvent::NAME)]
    public function onUserCreate(UserCreateEvent $event): void
    {
        foreach (UserListener::DEFAULT_PREFERENCES as $preference) {
            $p = new Preference();
            $p->setUser($event->getUser());
            $p->setPkey($preference['pkey']);
            $p->setPvalue($preference['pvalue']);
            $this->entityManager->persist($p);
        }
        $this->entityManager->flush();
    }
}
