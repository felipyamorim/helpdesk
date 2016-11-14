<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Perfil;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPerfilData extends AbstractFixture  implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $perfil1 = new Perfil();
        $perfil1->setId(1);
        $perfil1->setNome('Usuário');
        $perfil1->setRole('ROLE_USUARIO');

        $perfil2 = new Perfil();
        $perfil2->setId(2);
        $perfil2->setNome('Técnico');
        $perfil2->setRole('ROLE_TECNICO');

        $perfil3 = new Perfil();
        $perfil3->setId(3);
        $perfil3->setNome('Adminsitrador');
        $perfil3->setRole('ROLE_ADMIN');

        $this->addReference('administrador-perfil', $perfil3);

        $manager->persist($perfil1);
        $manager->persist($perfil2);
        $manager->persist($perfil3);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}