<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Problema;
use AppBundle\Form\ProblemaType;
use AppBundle\Form\Filter\ProblemaFilterType;

/**
 * Problema controller.
 *
 * @Route("/admin/problema")
 */
class ProblemaController extends Controller
{
    /**
     * Lists all Problema entities.
     *
     * @Route("/", name="admin_problema_index", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Method({"GET","POST"})
     * @Template("@App/Admin/Problema/index.html.twig")
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('AppBundle:Problema')->createQueryBuilder('p');

        $form = $this->createForm(ProblemaFilterType::class);

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
            'problemas' => $pagination,
            'filter_form' => $form->createView()
        );
    }

    /**
     * Creates a new Problema entity.
     *
     * @Route("/new", name="admin_problema_new")
     * @Method({"GET", "POST"})
     * @Template("@App/Admin/Problema/new.html.twig")
     */
    public function newAction(Request $request)
    {
        $problema = new Problema();
        $form = $this->createForm('AppBundle\Form\ProblemaType', $problema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($problema);
            $em->flush();

            $this->addFlash('success', 'O registro foi criado com sucesso!');

            return $this->redirectToRoute('admin_problema_show', array('id' => $problema->getIdProblema()));
        }

        return array(
            'problema' => $problema,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Problema entity.
     *
     * @Route("/{id}", name="admin_problema_show")
     * @Method("GET")
     * @Template("@App/Admin/Problema/show.html.twig")
     */
    public function showAction(Problema $problema)
    {

        return array(
            'problema' => $problema,
        );
    }

    /**
     * Displays a form to edit an existing Problema entity.
     *
     * @Route("/{id}/edit", name="admin_problema_edit")
     * @Method({"GET", "POST"})
     * @Template("@App/Admin/Problema/edit.html.twig")
     */
    public function editAction(Request $request, Problema $problema)
    {
        $editForm = $this->createForm('AppBundle\Form\ProblemaType', $problema);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($problema);
            $em->flush();

            $this->addFlash('success', 'O registro foi editado com sucesso!');

            return $this->redirectToRoute('admin_problema_show', array('id' => $problema->getIdProblema()));
        }

        return array(
            'problema' => $problema,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Problema entity.
     *
     * @Route("/{id}/delete", name="admin_problema_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Problema $problema)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($problema);
        $em->flush();

        $this->addFlash('success', 'O registro foi deletado com sucesso!');

        return $this->redirectToRoute('admin_problema_index');
    }

}
