<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Unidade;
use AppBundle\Form\UnidadeType;
use AppBundle\Form\Filter\UnidadeFilterType;

/**
 * Unidade controller.
 *
 * @Route("/admin/unidade")
 */
class UnidadeController extends Controller
{
    /**
     * Lists all Unidade entities.
     *
     * @Route("/", name="admin_unidade_index", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Method({"GET","POST"})
     * @Template("@App/Admin/Unidade/index.html.twig")
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('AppBundle:Unidade')->createQueryBuilder('u');

        $form = $this->createForm(UnidadeFilterType::class);

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
            'unidades' => $pagination,
            'filter_form' => $form->createView()
        );
    }

    /**
     * Creates a new Unidade entity.
     *
     * @Route("/new", name="admin_unidade_new")
     * @Method({"GET", "POST"})
     * @Template("@App/Admin/Unidade/new.html.twig")
     */
    public function newAction(Request $request)
    {
        $unidade = new Unidade();
        $form = $this->createForm('AppBundle\Form\UnidadeType', $unidade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unidade);
            $em->flush();

            $this->addFlash('success', 'O registro foi criado com sucesso!');

            return $this->redirectToRoute('admin_unidade_show', array('id' => $unidade->getIdUnidade()));
        }

        return array(
            'unidade' => $unidade,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Unidade entity.
     *
     * @Route("/{id}", name="admin_unidade_show")
     * @Method("GET")
     * @Template("@App/Admin/Unidade/show.html.twig")
     */
    public function showAction(Unidade $unidade)
    {

        return array(
            'unidade' => $unidade,
        );
    }

    /**
     * Displays a form to edit an existing Unidade entity.
     *
     * @Route("/{id}/edit", name="admin_unidade_edit")
     * @Method({"GET", "POST"})
     * @Template("@App/Admin/Unidade/edit.html.twig")
     */
    public function editAction(Request $request, Unidade $unidade)
    {
        $editForm = $this->createForm('AppBundle\Form\UnidadeType', $unidade);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unidade);
            $em->flush();

            $this->addFlash('success', 'O registro foi editado com sucesso!');

            return $this->redirectToRoute('admin_unidade_show', array('id' => $unidade->getIdUnidade()));
        }

        return array(
            'unidade' => $unidade,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Unidade entity.
     *
     * @Route("/{id}/delete", name="admin_unidade_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Unidade $unidade)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($unidade);
        $em->flush();

        $this->addFlash('success', 'O registro foi deletado com sucesso!');

        return $this->redirectToRoute('admin_unidade_index');
    }

}
