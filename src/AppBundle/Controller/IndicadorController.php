<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class IndicadorController extends Controller
{

    public function resolvidoAbertoAction()
    {
        $data = array(
            array('label' => "Em Aberto", 'value' => 12),
            array('label' => "Em Atendimento", 'value' => 30),
            array('label' => "Fechados", 'value' => 30),
            array('label' => "Cancelados", 'value' => 30)
        );

        return $this->render('AppBundle:Indicador:resolvido_aberto.html.twig', array('data' => $data));
    }

    public function balancoAnualAction()
    {
        $month = array(
            1 => 'Jan',
            2 => 'Fev',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'Mai',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Set',
            10 => 'Out',
            11 => 'Nov',
            12 => 'Dec',
        );

        $balancoArray = $this->getDoctrine()->getRepository('AppBundle:Chamado')->balancoChamados();

        $balanco = array_map(function($balancoArray) use ($month){
            $balancoArray['month'] = $month[$balancoArray['month']];
            return $balancoArray;
        }, $balancoArray);

        return $this->render('AppBundle:Indicador:balanco_anual.html.twig', array(
            'balanco' => $balanco
        ));
    }

    public function countChamadosAction()
    {
        return $this->render('@App/Indicador/total_chamados.html.twig', array(
            'chamados' => $this->getDoctrine()->getRepository('AppBundle:Chamado')->count()
        ));
    }

    public function countUsuariosAction()
    {
        return $this->render('@App/Indicador/usuario_registrado.html.twig', array(
            'usuarios' => $this->getDoctrine()->getRepository('AppBundle:Usuario')->count()
        ));
    }

    public function porcentagemChamadosAction()
    {
        return $this->render('@App/Indicador/porcentagem_chamados.html.twig', array(
            'porcentagem' => $this->getDoctrine()->getRepository('AppBundle:Chamado')->porcentagemChamados()
        ));
    }

    public function pendenteChamadosAction()
    {
        return $this->render('@App/Indicador/pendentes_chamados.html.twig', array(
            'chamados' => $this->getDoctrine()->getRepository('AppBundle:Chamado')->pendentesChamados()
        ));
    }

    public function chamadoUnidadeAction()
    {
        $chamados = $this->getDoctrine()->getRepository('AppBundle:Chamado')->chamadosXUnidades();

        $labels = array(
            'labels' => array(),
            'datasets' => array(array('data' => array(), 'backgroundColor' => array()))
        );

        foreach ($chamados as $chamado){
            $labels['labels'][] = $chamado['nome'];
            $labels['datasets'][0]['data'][] = (int)$chamado['total'];
            $labels['datasets'][0]['backgroundColor'][] = '#525d37';
        }

        return $this->render('@App/Indicador/chamado_unidade.html.twig', array(
            'chamados' => $labels
        ));
    }

    public function topProblemaAction()
    {
        $chamados = $this->getDoctrine()->getRepository('AppBundle:Chamado')->topProblema();

        $labels = array(
            'labels' => array(),
            'datasets' => array(array('data' => array(), 'backgroundColor' => array()))
        );

        foreach ($chamados as $chamado){
            $labels['labels'][] = $chamado['nome'];
            $labels['datasets'][0]['data'][] = (int)$chamado['total'];
            $labels['datasets'][0]['backgroundColor'][] = '#525d37';
        }

        return $this->render('@App/Indicador/top10_problema.html.twig', array(
            'chamados' => $labels
        ));
    }

    public function chamadoAbertosAction(){
        return $this->render('@App/Indicador/chamados_abertos.html.twig', array(
            'chamados' => $this->getDoctrine()->getRepository('AppBundle:Chamado')->listarChamadosPendentes()
        ));
    }
}
