<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Anexo;
use AppBundle\Entity\Comentario;
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
 * @Route("/admin/chamado")
 */
class AdminChamadoController extends Controller
{
    /**
     * Lists all AdminChamado entities.
     *
     * @Route("/", name="admin_chamado_index", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Method({"GET","POST"})
     * @Template("@App/Admin/Chamado/index.html.twig")
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('AppBundle:Chamado')->createQueryBuilder('c');

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
     * @Route("/new", name="admin_chamado_new")
     * @Method({"GET", "POST"})
     * @Template("@App/Admin/Chamado/new.html.twig")
     */
    public function newAction(Request $request)
    {
        $chamado = new Chamado();
        $form = $this->createForm('AppBundle\Form\ChamadoType', $chamado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            foreach ($chamado->getFiles() as $file){
                if($file){
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('anexo_directory').'/', $fileName);

                    $anexo = new Anexo();
                    $anexo->setCaminho($fileName);
                    $chamado->addAnexo($anexo);
                }
            }

            $em = $this->getDoctrine()->getManager();

            // Adicionar status de em aberto para o chamado
            $chamado->setStatus($em->getReference('AppBundle\Entity\Status', 1));
            $chamado->setData(new \DateTime());

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
     * @Route("/{id}", name="admin_chamado_show")
     * @Method({"GET", "POST"})
     * @Template("@App/Admin/Chamado/show.html.twig")
     */
    public function showAction(Chamado $chamado, Request $request)
    {
        $comentario = new Comentario();
        $form = $this->createForm('AppBundle\Form\ComentarioType', $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comentario->setData(new \DateTime());
            $comentario->setMensagem($request->get('comentario')['mensagem']);
            $comentario->setUsuario($this->getUser());

            $chamado->addComentario($comentario);

            $em = $this->getDoctrine()->getManager();
            $em->persist($chamado);
            $em->flush();

            $this->addFlash('success', 'Comentário adicionado com sucesso!');

            return $this->redirectToRoute('chamado_show', array('id' => $chamado->getIdChamado()));
        }

        return array(
            'chamado' => $chamado,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing AdminChamado entity.
     *
     * @Route("/{id}/edit", name="admin_chamado_edit")
     * @Method({"GET", "POST"})
     * @Template("@App/Admin/Chamado/edit.html.twig")
     */
    public function editAction(Request $request, Chamado $chamado)
    {
        $editForm = $this->createForm('AppBundle\Form\ChamadoType', $chamado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chamado);
            $em->flush();

            $this->addFlash('success', 'O registro foi editado com sucesso!');

            return $this->redirectToRoute('admin_chamado_show', array('id' => $chamado->getIdChamado()));
        }

        return array(
            'chamado' => $chamado,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a AdminChamado entity.
     *
     * @Route("/{id}/delete", name="admin_chamado_delete")
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
