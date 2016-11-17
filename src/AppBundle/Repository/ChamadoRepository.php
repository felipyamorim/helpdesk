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
        return $this->createQueryBuilder('c')
            ->select('count(c.idChamado) as total')
            ->addSelect('(select count(c1.idChamado) from AppBundle:Chamado c1 where c1.status = 3) as total_fechados')
            ->getQuery()
            ->getSingleResult();
    }

    public function pendentesChamados(){
        $qb = $this->createQueryBuilder('c');
        return $qb
            ->select('count(c.idChamado)')
            ->where($qb->expr()->notIn('c.status', array(3,4)))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function listarChamadosPendentes(){
        $qb = $this->createQueryBuilder('c');
        return $qb
            ->where($qb->expr()->notIn('c.status', array(3,4)))
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function balancoChamados(){

        $sql = 'SELECT 
                    m.month,
                    (SELECT count(idChamado) from chamado where month(data) = m.month) as total,
                    (SELECT count(idChamado) from chamado where month(data) = m.month and status = 1) as abertos,
                    (SELECT count(idChamado) from chamado where month(data) = m.month and status = 2) as atendimentos,
                    (SELECT count(idChamado) from chamado where month(data) = m.month and status = 3) as fechados,
                    (SELECT count(idChamado) from chamado where month(data) = m.month and status = 4) as cancelados
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