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

    public function pendentesChamados(){
        return $this->createQueryBuilder('c')
            ->select('count(c.idChamado)')
            ->where('c.status is null')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function listarChamadosPendentes(){
        return $this->createQueryBuilder('c')
            ->where('c.status is null')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function balancoChamados(){

        $sql = 'SELECT 
                    m.month,
                    (SELECT count(idChamado) from chamado where month(data) = m.month and status is null) as abertos,
                    (SELECT count(idChamado) from chamado where month(data) = m.month and status is not null) as fechados
                FROM
                (
                    SELECT (month(CURDATE())) AS MONTH 
                    UNION SELECT (month(CURDATE()) - 1) AS MONTH 
                    UNION SELECT (month(CURDATE()) - 2) AS MONTH 
                    UNION SELECT (month(CURDATE()) - 3) AS MONTH 
                    UNION SELECT (month(CURDATE()) - 4) AS MONTH 
                    UNION SELECT (month(CURDATE()) - 5) AS MONTH
                ) AS m
                ORDER BY m.month ASC';

        return $this->getEntityManager()
            ->getConnection()
            ->query($sql)
            ->fetchAll();
    }

    public function chamadosXUnidades(){
        return $this->createQueryBuilder('c')
            ->select('unidade.nome, count(unidade.nome) as total')
            ->innerJoin('c.usuario', 'usuario')
            ->innerJoin('usuario.unidade', 'unidade')
            ->groupBy('unidade.nome')
            ->getQuery()
            ->getResult();
    }

    public function topProblema(){
        return $this->createQueryBuilder('c')
            ->select('p.nome, count(p.nome) as total')
            ->innerJoin('c.problema', 'p')
            ->groupBy('p.nome')
            ->getQuery()
            ->getResult();
    }
}