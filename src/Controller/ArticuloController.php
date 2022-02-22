<?php

namespace App\Controller;

use App\Entity\Articulo;
use App\Repository\ArticuloRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticuloType;

class ArticuloController extends AbstractController
{

    public function newArticle()
    {
        $this->redirectToRoute('form-nuevo');
    }

    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $articulos = $doctrine->getRepository(Articulo::class)->findAll();
        $categorias = $doctrine->getRepository(Articulo::class)->findAllCategorias();

        if (!$articulos) {
            throw $this->createNotFoundException('Articulos no encontrados');
        }

        return $this->render('home.html.twig', ['articulos' => $articulos, 'categorias' => $categorias]);
    }


    #[Route('/nuevo', name: 'form-nuevo')]
    public function nuevoArticulo(Request $request, ManagerRegistry $doctrine): Response
    {
        $articulo = new Articulo();
        $form = $this->createForm(ArticuloType::class, $articulo);

        $entityManager = $doctrine->getManager();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articulo = $form->getData();

            $entityManager->persist($articulo);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('nuevo_articulo.html.twig', ['form' => $form]);
    }

    #[Route('/articulo/{id}', name: 'detalles-articulo')]
    public function detallesArticulo(ManagerRegistry $doctrine, int $id): Response
    {
        $articulo = $doctrine->getRepository(Articulo::class)->find($id);

        if (!$articulo) {
            throw $this->createNotFoundException('Articulo no encontrado con el id ' . $id);
        }

        return $this->render('detalles_articulo.html.twig', ['articulo' => $articulo]);
    }

    #[Route('/editar/{id}', name: 'editar-articulo')]
    public function editarArticulo(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $articulo = $doctrine->getRepository(Articulo::class)->find($id);

        $entityManager = $doctrine->getManager();

        if (!$articulo) {
            throw $this->createNotFoundException('Articulo no encontrado con el id ' . $id);
        }

        $form = $this->createForm(ArticuloType::class, $articulo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articulo = $form->getData();

            $entityManager->persist($articulo);
            $entityManager->flush();

            return $this->redirectToRoute('detalles-articulo', array('id' => $id));
        }

        return $this->renderForm('editar_articulo.html.twig', ['form' => $form]);
    }

    #[Route('/eliminar/{id}', name: 'eliminar-articulo')]
    public function borrarArticulo(ManagerRegistry $doctrine, int $id): Response
    {
        $articulo = $doctrine->getRepository(Articulo::class)->find($id);

        if (!$articulo) {
            throw $this->createNotFoundException('Articulo no encontrado con el id ' . $id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($articulo);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    #[Route('/filtro-articulos/{nombreCat}', name: 'filtro-articulos')]
    public function filtrarArticulosPorCategoria(ManagerRegistry $doctrine, string $nombreCat): Response
    {
        $articulos = $doctrine->getRepository(Articulo::class)->findAllArticulosOfCategoria($nombreCat);
        $categorias = $doctrine->getRepository(Articulo::class)->findAllCategorias();

        return $this->render('home.html.twig', ['articulos' => $articulos, 'categorias' => $categorias]);
    }
}
