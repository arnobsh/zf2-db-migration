<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fixture\Album;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Album\Entity\Album;
class AlbumFixtureLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $album = new Album();
        $album->setArtist("Test Artist");
        $album->setDetails("Details bla bla");
        $album->setTest("test data");
        $album->setEmpid("1");
        $album->setTitle("test");

        $manager->persist($album);
        $manager->flush();
    }
}