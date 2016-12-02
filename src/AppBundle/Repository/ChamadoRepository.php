<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Problema;
use AppBundle\Entity\Status;
use AppBundle\Entity\Unidade;
use AppBundle\Entity\Usuario;
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

    public function statusChamados(Unidade $unidade){
        return $this->createQueryBuilder('c')
            ->select('s.nome as label, count(c.idChamado) as value')
            ->join('c.status', 's')
            ->join('c.usuario', 'u')
            ->where('u.unidade = :unidade')
            ->setParameter(':unidade', $unidade)
            ->groupBy('c.status')
            ->getQuery()
            ->getResult();
    }

    public function listarChamadosPendentes($unidade = null){
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where($qb->expr()->notIn('c.status', array(3,4)));
            if($unidade) {
                $qb
                    ->join('c.usuario', 'u')
                    ->andWhere('u.unidade = :unidade')
                    ->setParameter(':unidade', $unidade);
            }
        return $qb
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

    public function relatorioChamadoStatus(array $periodo, Status $status = null){
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.data > :dataInicial')
            ->andWhere('c.data < :dataFinal')
            ->setParameter(':dataInicial', $periodo['inicio'])
            ->setParameter(':dataFinal', $periodo['fim']);

            /** @var Status $status */
            if($status->getIdStatus() != 0){
                $qb
                    ->andWhere('c.status = :status')
                    ->setParameter(':status', $status);
            }

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function relatorioChamadoUnidade(array $periodo, Unidade $unidade = null){
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.data > :dataInicial')
            ->andWhere('c.data < :dataFinal')
            ->setParameter(':dataInicial', $periodo['inicio'])
            ->setParameter(':dataFinal', $periodo['fim']);

        /** @var Unidade $unidade */
        if($unidade->getIdUnidade() != 0){
            $qb
                ->join('c.usuario', 'u')
                ->andWhere('u.unidade = :unidade')
                ->setParameter(':unidade', $unidade);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function relatorioChamadoProblema(array $periodo, Problema $problema = null){
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.data > :dataInicial')
            ->andWhere('c.data < :dataFinal')
            ->setParameter(':dataInicial', $periodo['inicio'])
            ->setParameter(':dataFinal', $periodo['fim']);

        /** @var Problema $problema */
        if($problema->getIdProblema() != 0){
            $qb
                ->andWhere('c.problema = :problema')
                ->setParameter(':problema', $problema);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function relatorioChamadoTecnico(array $periodo, Usuario $tecnico = null){
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.data > :dataInicial')
            ->andWhere('c.data < :dataFinal')
            ->setParameter(':dataInicial', $periodo['inicio'])
            ->setParameter(':dataFinal', $periodo['fim']);

        /** @var Usuario $tecnico */
        if($tecnico->getIdUsuario() != 0){
            $qb
                ->andWhere('c.tecnico = :tecnico')
                ->setParameter(':tecnico', $tecnico);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }
}