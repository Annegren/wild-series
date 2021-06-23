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
        ['title' => 'Episode 1', 'number' => 1, 'summary' => 'Synopsis'],
        ['title' => 'Episode 2', 'number' => 2, 'summary' => 'Synopsis'],
        ['title' => 'Episode 3', 'number' => 3, 'summary' => 'Synopsis'],
        ['title' => 'Episode 4', 'number' => 4, 'summary' => 'Synopsis'],
        ['title' => 'Episode 5', 'number' => 5, 'summary' => 'Synopsis']
        
    
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::EPISODES as $row => $value) {
            $episode = new Episode();
            $episode->setTitle($value['title']);
            $episode->setSlug($this->input->generate($episode->getTitle($value['title'])));
            $episode->setSeason($this->getReference('season_0'));
            $episode->setNumber($value['number']);
            $episode->setSynopsis($value['summary']);
            $manager->persist($episode);
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
