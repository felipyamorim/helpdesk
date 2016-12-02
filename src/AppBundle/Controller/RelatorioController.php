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
            $periodo = array();
            list($periodo['inicio'], $periodo['fim']) = explode(' - ', $request->get('daterange'));
            $status = $this->getDoctrine()->getManager()->getReference('AppBundle:Status', $request->get('status'));

            // Converter periodo em DateTime
            $periodo = array_map(function($data){
                return \DateTime::createFromFormat('d/m/Y', $data);
            }, $periodo);

            $resultado = $this->getDoctrine()->getRepository('AppBundle:Chamado')->relatorioChamadoStatus($periodo, $status);

            $html = $this->render('relatorio/output/report.html.twig', array(
                'chamados' => $resultado,
                'periodo' => $request->get('daterange'),
                'nome' => 'Relatório gerencial de chamados por Status'
            ))->getContent();

            $filename = sprintf('relatorio_status_%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }

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
            $periodo = array();
            list($periodo['inicio'], $periodo['fim']) = explode(' - ', $request->get('daterange'));
            $unidade = $this->getDoctrine()->getManager()->getReference('AppBundle:Unidade', $request->get('unidade'));

            // Converter periodo em DateTime
            $periodo = array_map(function($data){
                return \DateTime::createFromFormat('d/m/Y', $data);
            }, $periodo);

            $resultado = $this->getDoctrine()->getRepository('AppBundle:Chamado')->relatorioChamadoUnidade($periodo, $unidade);

            $html = $this->render('relatorio/output/report.html.twig', array(
                'chamados' => $resultado,
                'periodo' => $request->get('daterange'),
                'nome' => 'Relatório gerencial de chamados por Unidade'
            ))->getContent();

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
            $periodo = array();
            list($periodo['inicio'], $periodo['fim']) = explode(' - ', $request->get('daterange'));

            $problema = $this->getDoctrine()->getManager()->getReference('AppBundle:Problema', $request->get('problema'));

            // Converter periodo em DateTime
            $periodo = array_map(function($data){
                return \DateTime::createFromFormat('d/m/Y', $data);
            }, $periodo);

            $resultado = $this->getDoctrine()->getRepository('AppBundle:Chamado')->relatorioChamadoProblema($periodo, $problema);

            $html = $this->render('relatorio/output/report.html.twig', array(
                'chamados' => $resultado,
                'periodo' => $request->get('daterange'),
                'nome' => 'Relatório gerencial de chamados por Problema'
            ))->getContent();

            $filename = sprintf('%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }


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
            $periodo = array();
            list($periodo['inicio'], $periodo['fim']) = explode(' - ', $request->get('daterange'));
            $tecnico = $this->getDoctrine()->getManager()->getReference('AppBundle:Usuario', $request->get('tecnico'));

            // Converter periodo em DateTime
            $periodo = array_map(function($data){
                return \DateTime::createFromFormat('d/m/Y', $data);
            }, $periodo);

            $resultado = $this->getDoctrine()->getRepository('AppBundle:Chamado')->relatorioChamadoTecnico($periodo, $tecnico);

            $html = $this->render('relatorio/output/report.html.twig', array(
                'chamados' => $resultado,
                'periodo' => $request->get('daterange'),
                'nome' => 'Relatório gerencial de chamados por Técnico'
            ))->getContent();

            $filename = sprintf('%s.pdf', date('Y-m-d'));

            return $this->exportPDF($html, $filename);
        }

        $em = $this->getDoctrine()->getManager();


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

        $pdf = $this->get('knp_snappy.pdf');
        $pdf->setOption('footer-html', $this->render(':relatorio/output:footer.html.twig')->getContent());

        return new Response(
            $pdf->getOutputFromHtml($html, array('orientation' => 'Landscape')),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    }

}
