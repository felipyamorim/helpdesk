<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture  implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new Usuario();
        $userAdmin->setNome('Felipy Amorim');
        $userAdmin->setEmail('felipyamorim@gmail.com');
        $userAdmin->setSenha('dde853042f4e9e715cd0457dd2d233240a41300b1c87ec954508b1f3ab7c37aaaec73bac0423795f9030052976456c58602e33a7ad7a9b96fa35250612fa061a');
        $userAdmin->setPerfil($this->getReference('administrador-perfil'));
        $userAdmin->setUnidade($this->getReference('unidade'));

        $manager->persist($userAdmin);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}