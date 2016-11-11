<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Unidade;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUnidadeData extends AbstractFixture  implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $unidade = new Unidade();
        $unidade->setNome('D-DST AIDS');

        $this->addReference('unidade', $unidade);

        $manager->persist($unidade);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}