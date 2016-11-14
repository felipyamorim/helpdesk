<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Anexo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Chamado;
use AppBundle\Form\ChamadoType;
use AppBundle\Form\Filter\ChamadoFilterType;

/**
 * AdminChamado controller.
 *
 * @Route("/chamado")
 */
class ChamadoController extends Controller
{
    /**
     * Lists all AdminChamado entities.
     *
     * @Route("/", name="chamado_index", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Method({"GET","POST"})
     * @Template()
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('AppBundle:Chamado')->createQueryBuilder('c');
        // Apenas tem acesso aos chamados abertos por sua Unidade
        $query
            ->join('c.usuario', 'u')
            ->where('u.unidade = :unidade')
            ->setParameter(':unidade', $this->getUser()->getUnidade())
            ->orderBy('c.prioridade',  'DESC');

        //  dump($query);die;

        $form = $this->createForm(ChamadoFilterType::class);

        if ($request->request->has($form->getName())) {
            $form->submit($request->get($form->getName()));
            $request->getSession()->set($form->getName(),$request->get($form->getName()));
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $query);
        }else if($request->getSession()->has($form->getName())){
            $form->submit($request->getSession()->get($form->getName()));
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $query);
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page, /*page number*/
            10 /*limit per page*/
        );

        return array(
            'chamados' => $pagination,
            'filter_form' => $form->createView()
        );
    }

    /**
     * Creates a new AdminChamado entity.
     *
     * @Route("/new", name="chamado_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $chamado = new Chamado();
        $form = $this->createForm('AppBundle\Form\ChamadoType', $chamado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chamado->setData(new \DateTime());

            /** @var UploadedFile $file */
            foreach ($chamado->getFiles() as $file){
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('anexo_directory').'/', $fileName);

                $anexo = new Anexo();
                $anexo->setCaminho($fileName);
                $chamado->addAnexo($anexo);

            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($chamado);
            $em->flush();

            $this->addFlash('success', 'O chamado foi criado com sucesso!');

            return $this->redirectToRoute('admin_chamado_show', array('id' => $chamado->getIdChamado()));
        }

        return array(
            'chamado' => $chamado,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a AdminChamado entity.
     *
     * @Route("/{id}", name="chamado_show")
     * @Method("GET")
     */
    public function showAction(Chamado $chamado)
    {
        return $this->render('AppBundle:AdminChamado:show.html.twig', array(
            'chamado' => $chamado,
        ));
    }

    /**
     * Deletes a AdminChamado entity.
     *
     * @Route("/{id}/delete", name="chamado_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Chamado $chamado)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($chamado);
        $em->flush();

        $this->addFlash('success', 'O registro foi deletado com sucesso!');

        return $this->redirectToRoute('admin_chamado_index');
    }

}
