<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function editPerfilAction(Request $request)
    {

        $usuario = $this->getUser();
        $editForm = $this->createForm('AppBundle\Form\RegistrarType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            /** @var UploadedFile $file */
            if($file = $usuario->getFile()){
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('profile_directory').'/',
                    $fileName
                );
                $usuario->setFoto($fileName);
            }

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

    /**
     * @Route("/registrar", name="usuario_registrar")s
     */
    public function registerAction(Request $request)
    {
        $usuario = new Usuario();
        $editForm = $this->createForm('AppBundle\Form\RegistrarType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /** @var UploadedFile $file */
            if($file = $usuario->getFile()){
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('profile_directory').'/',
                    $fileName
                );
                $usuario->setFoto($fileName);
            }

            $em = $this->getDoctrine()->getManager();

            $usuario->setPerfil($em->getReference('AppBundle\Entity\Perfil', 1));
            $usuario->setSenha(hash('sha512', $usuario->getSenha()));

            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', 'Usuário registrado com sucesso, faça o login!');

            return $this->redirectToRoute('login', array('last_username' => $usuario->getEmail()));
        }

        return $this->render('security/registrar.html.twig', array(
            'edit_form' => $editForm->createView()
        ));
    }

}
