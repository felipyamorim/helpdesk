<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('app/index.html.twig');
    }

    /**
     * @Route("/perfil", name="edit_perfil")
     */
    public function editePerfilAction(Request $request)
    {

        $usuario = $this->getUser();
        $editForm = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', 'O registro foi editado com sucesso!');

            return $this->redirectToRoute('edit_perfil', array('id' => $usuario->getIdUsuario()));
        }

        return $this->render('app/perfil.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
        ));
    }

}
