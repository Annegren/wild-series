<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Episode;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Service\Slugify;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    private $input;

    public function __construct(Slugify $input)
    {
        $this->input = $input;
    }

    const EPISODES = [
        'episode 1',
        'episode 2',
        'episode 3',
        'episode 4',
        'episode 5',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::EPISODES as $key => $episodes) {
            $episode = new Episode();
            $episode->setTitle($episodes);;
            $episode->setSlug($this->input->generate($episode->getTitle()));

            $episode->setSeason($this->getReference('season_0'));
            $episode->setNumber($key);
            $episode->setSynopsis('Synopsis Des zombies envahissent la terre');
            $manager->persist($episode);
            $this->addReference('episode_' . $key, $episode);
        }  

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          SeasonFixtures::class,
        ];
    }
}
