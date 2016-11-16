<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Status;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadStatusData extends AbstractFixture  implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $status1 = new Status();
        $status1->setId(1);
        $status1->setNome('Em Aberto');

        $status2 = new Status();
        $status2->setId(2);
        $status2->setNome('Em Atendimento');

        $status3 = new Status();
        $status3->setId(3);
        $status3->setNome('Finalizado');

        $status4 = new Status();
        $status4->setId(4);
        $status4->setNome('Cancelado');

        $manager->persist($status1);
        $manager->persist($status2);
        $manager->persist($status3);
        $manager->persist($status4);
        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}