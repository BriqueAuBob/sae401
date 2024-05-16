<?php

namespace App\DataFixtures;

use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Preference;
use App\Entity\User;
use App\EventListener\UserListener;

class PreferenceFixture extends Fixture
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $preferences = UserListener::DEFAULT_PREFERENCES;

        foreach ($this->userRepository->findAll() as $user) {
            $userPreferences = $user->getPreferences();
            foreach ($preferences as $preference) {
                $exists = false;
                foreach ($userPreferences as $userPreference) {
                    if ($userPreference['pkey'] === $preference['pkey']) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $p = new Preference();
                    $p->setUser($user);
                    $p->setPkey($preference['pkey']);
                    $p->setPvalue($preference['pvalue']);

                    $manager->persist($p);
                }
            }
        }

        $manager->flush();
    }
}
