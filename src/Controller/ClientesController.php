<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;
use App\Form\UsuariosType;
use App\Entity\Usuarios;

class ClientesController extends AbstractController
{

    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * @Route("/", name="app_clientes", methods={"GET"})
     */
    public function index()
    {   

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(Usuarios::class)->findAll();

        return $this->render('cliente/index.html.twig', [
            'users' => $users
        ]);

    }
    
    /**
     * @Route("/cliente/create", name="app_clientes_create", methods={"GET", "POST"})
     */
    public function create(Request $request)
    {

        $usuario = new Usuarios();
        $form = $this->createForm(UsuariosType::class, $usuario);

        if ($request->isMethod('POST')) {

            try {

                $form->handleRequest($request);

                $user = $form->getData();

                $file = $request->files->get('foto');

                $newFilename = null;

                if (!empty($file)) {

                    $filename = $file->getClientOriginalName();
                    $uploadDir = $this->getParameter("kernel.project_dir") . "/public/uploads";

                    $newFilename = $this->uploader->upload($uploadDir, $file, $filename);

                }
                
                $em = $this->getDoctrine()->getManager();

                $user->setFoto($newFilename);

                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Cliente adicionado com sucesso!');
                return $this->redirectToRoute('app_clientes');

            } catch(\Exception $e) {
                $this->addFlash('danger', 'Falha ao adicionar cliente!');
                return $this->redirectToRoute('app_clientes_create');
            }

        }

        return $this->render('cliente/create.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/cliente/edit/{id}", name="app_clientes_edit", methods={"GET", "POST"})
     */
    public function edit(Usuarios $user, Request $request)
    {

        $form = $this->createForm(UsuariosType::class, $user);

        if ($request->isMethod('POST')) {

            try {

                $form->handleRequest($request);
                
                $user = $form->getData();

                $file = $request->files->get('foto');

                if (!empty($file)) {

                    $uploadDir = $this->getParameter("kernel.project_dir") . "/public/uploads";

                    // Remove imagem antiga, caso exista
                    if (!empty($user->getFoto()) && file_exists($uploadDir . '/' . $user->getFoto())) {
                        unlink($uploadDir . '/' . $user->getFoto());
                    }

                    $newFilename = $this->uploader->upload($uploadDir, $file, $file->getClientOriginalName());

                    $user->setFoto($newFilename);

                }
                
                $em = $this->getDoctrine()->getManager();
                
                $em->merge($user);
                $em->flush();
                
                $this->addFlash('success', 'Cliente editado com sucesso!');
                return $this->redirectToRoute('app_clientes');

            } catch(\Exception $e) {
                $this->addFlash('danger', 'Falha ao editar cliente!');
                return $this->redirectToRoute('app_clientes_edit', ['id' => $user->getId()]);
            }

        }

        return $this->render('cliente/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
        
    }

    /**
     * @Route("/cliente/show/{id}", name="app_clientes_show", methods={"GET"})
     */
    public function show(Usuarios $user)
    {
        return $this->render('cliente/show.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/cliente/delete/{id}", name="app_clientes_delete", methods={"POST"})
     */
    public function delete(Usuarios $user)
    {

        try {

            $em = $this->getDoctrine()->getManager();

            // unlink da imagem, caso exista
            $uploadDir = $this->getParameter("kernel.project_dir") . "/public/uploads/";

            if (!empty($user->getFoto()) && file_exists($uploadDir . $user->getFoto())) {
                unlink($uploadDir . $user->getFoto());
            }

            $em->remove($user);
            $em->flush();

            return new JsonResponse([
                'code' => JsonResponse::HTTP_OK,
                'message' => 'Cliente removido com sucesso!'
            ]);
            
        } catch(\Exception $e) {
            return new JsonResponse([
                'code' => JsonResponse::HTTP_BAD_REQUEST,
                'message' => 'Falha ao remover cliente!'
            ]);
        }
    }

}
