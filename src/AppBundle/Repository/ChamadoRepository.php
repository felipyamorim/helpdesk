<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ChamadoRepository extends EntityRepository
{
    public function count(){
        return $this->createQueryBuilder('c')
            ->select('count(c.idChamado)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function porcentagemChamados(){
        return $this->getEntityManager()
            ->getConnection()
            ->query('select count(c1.idChamado) as total, (select count(c2.idChamado) from chamado c2 where c2.status is not null) as total_fechados from chamado c1')
            ->fetch();
    }

    public function pendentesChmados(){
        return $this->getEntityManager()
            ->getConnection()
            ->query('select count(c2.idChamado) from chamado c2 where c2.status is null1')
            ->fetch();
    }
}