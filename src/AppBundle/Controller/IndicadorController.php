<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class IndicadorController extends Controller
{

    public function resolvidoAbertoAction()
    {
        $data = array(
            array('label' => "Abertos", 'value' => 12),
            array('label' => "Resolvidos", 'value' => 30)
        );

        return $this->render('AppBundle:Indicador:resolvido_aberto.html.twig', array('data' => $data));
    }

    public function balancoAnualAction()
    {
        return $this->render('AppBundle:Indicador:balanco_anual.html.twig', array(
            // ...
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
            'chamados' => $this->getDoctrine()->getRepository('AppBundle:Chamado')->porcentagemChamados()
        ));
    }
}
