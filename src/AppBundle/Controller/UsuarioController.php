<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use AppBundle\Form\Filter\UsuarioFilterType;

/**
 * Usuario controller.
 *
 * @Route("/admin/usuario")
 */
class UsuarioController extends Controller
{
    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="admin_usuario_index", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Method({"GET","POST"})
     * @Template()
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('AppBundle:Usuario')->createQueryBuilder('u');

        $form = $this->createForm(UsuarioFilterType::class);

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
            'usuarios' => $pagination,
            'filter_form' => $form->createView()
        );
    }

    /**
     * Creates a new Usuario entity.
     *
     * @Route("/new", name="admin_usuario_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', 'O registro foi criado com sucesso!');

            return $this->redirectToRoute('admin_usuario_show', array('id' => $usuario->getIdUsuario()));
        }

        return array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}", name="admin_usuario_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Usuario $usuario)
    {
        return array(
            'usuario' => $usuario,
        );
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="admin_usuario_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $editForm = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', 'O registro foi editado com sucesso!');

            return $this->redirectToRoute('admin_usuario_show', array('id' => $usuario->getIdUsuario()));
        }

        return array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}/delete", name="admin_usuario_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($usuario);
        $em->flush();

        $this->addFlash('success', 'O registro foi deletado com sucesso!');

        return $this->redirectToRoute('admin_usuario_index');
    }

}
