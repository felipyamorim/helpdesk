<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Relatorio controller.
 *
 * @Route("/admin/relatorio")
 */
class RelatorioController extends Controller
{
    /**
     * @Route("/status", name="relatorio_chamados_status")
     */
    public function chamadosStatusAction(Request $request)
    {
        if($request->isMethod('POST')){
            $date = array();
            list($date['inicio'], $date['fim']) = explode(' - ', $request->get('daterange'));

            $html = "Relatório";

            $filename = sprintf('%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }
        // replace this example code with whatever you need
        return $this->render('relatorio/status.html.twig', array(
            'status' => $this->getDoctrine()->getRepository('AppBundle:Status')->findBy(array(), array('idStatus' => 'asc'))
        ));
    }

    /**
     * @Route("/unidade", name="relatorio_chamados_unidade")
     */
    public function chamadosUnidadeAction(Request $request)
    {
        if($request->isMethod('POST')){
            $date = array();
            list($date['inicio'], $date['fim']) = explode(' - ', $request->get('daterange'));

            $html = $this->render('unidade.html.twig')->getContent();

            $filename = sprintf('%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }

        return $this->render('relatorio/unidade.html.twig', array(
            'unidades' => $this->getDoctrine()->getRepository('AppBundle:Unidade')->findAll()
        ));
    }

    /**
     * @Route("/problema", name="relatorio_chamados_problema")
     */
    public function chamadosProblemaAction(Request $request)
    {
        if($request->isMethod('POST')){
            $date = array();
            list($date['inicio'], $date['fim']) = explode(' - ', $request->get('daterange'));

            $html = "Relatório";

            $filename = sprintf('%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }

        // replace this example code with whatever you need
        return $this->render('relatorio/problema.html.twig', array(
            'problemas' => $this->getDoctrine()->getRepository('AppBundle:Problema')->findAll()
        ));
    }

    /**
     * @Route("/tecnico", name="relatorio_chamados_tecnico")
     */
    public function chamadosTecnicoAction(Request $request)
    {
        if($request->isMethod('POST')){
            $date = array();
            list($date['inicio'], $date['fim']) = explode(' - ', $request->get('daterange'));

            $html = "Relatório";

            $filename = sprintf('%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }

        $em = $this->getDoctrine()->getManager();

        // replace this example code with whatever you need
        return $this->render('relatorio/tecnico.html.twig', array(
            'tecnicos' => $em->getRepository('AppBundle:Usuario')->findBy(array(
                'perfil' => $em->getReference('AppBundle\Entity\Perfil', 2)
            ))
        ));
    }

    public function exportPDF($html, $filename)
    {
        if(empty($html))
            throw new \LogicException('É necessário informar o conteudo do relatório');

        if(empty($filename))
            throw new \LogicException('É necessário informar o nome do arquivo');

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    }

}
