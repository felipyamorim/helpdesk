<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\TipoTelefone;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTipoTelefoneData extends AbstractFixture  implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $telefone = new TipoTelefone();
        $telefone->setNome('Celular');

        $manager->persist($telefone);

        $telefone = new TipoTelefone();
        $telefone->setNome('Residencial');

        $manager->persist($telefone);

        $telefone = new TipoTelefone();
        $telefone->setNome('Comercial');

        $manager->persist($telefone);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}