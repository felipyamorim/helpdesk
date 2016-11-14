<?php

// src/AppBundle/Repository/ProductRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UsuarioRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where("u.email = :email")
            ->setParameter(':email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function count(){
        return $this->createQueryBuilder('u')
            ->select('count(u.idUsuario)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}