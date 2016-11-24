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
     * @Route("/atendidos", name="relatorio_chamados_atendidos")
     */
    public function chamadosAtendidosAction(Request $request)
    {
        if($request->isMethod('POST')){
            $date = array();
            list($date['inicio'], $date['fim']) = explode(' - ', $request->get('daterange'));

            $html = "Relatório";

            $filename = sprintf('%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }
        // replace this example code with whatever you need
        return $this->render('relatorio/atendidos.html.twig');
    }

    /**
     * @Route("/abertos", name="relatorio_chamados_abertos")
     */
    public function chamadosAbertosAction(Request $request)
    {
        if($request->isMethod('POST')){
            $date = array();
            list($date['inicio'], $date['fim']) = explode(' - ', $request->get('daterange'));

            $html = $this->render('relatorio/abertos.html.twig')->getContent();

            $filename = sprintf('%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }

        return $this->render('relatorio/abertos.html.twig');
    }

    /**
     * @Route("/problema", name="relatorio_atendimento_problema")
     */
    public function atendimentoProblemaAction(Request $request)
    {
        if($request->isMethod('POST')){
            $date = array();
            list($date['inicio'], $date['fim']) = explode(' - ', $request->get('daterange'));

            $html = "Relatório";

            $filename = sprintf('%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }

        // replace this example code with whatever you need
        return $this->render('relatorio/problema.html.twig');
    }

    /**
     * @Route("/tecnico", name="relatorio_atendimento_tecnico")
     */
    public function atendimentoTecnicoAction(Request $request)
    {
        if($request->isMethod('POST')){
            $date = array();
            list($date['inicio'], $date['fim']) = explode(' - ', $request->get('daterange'));

            $html = "Relatório";

            $filename = sprintf('%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }

        // replace this example code with whatever you need
        return $this->render('relatorio/tecnico.html.twig');
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
