<?php

namespace App\Http\Controller;

use App\Domain\Blog\Repository\PostRepository;
use App\Domain\Course\Repository\CourseRepository;
use App\Domain\Course\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CourseRepository $courseRepository, FormationRepository $formationRepository, PostRepository $postRepository): Response
    {
        return $this->render('pages/home.html.twig', [
            'courses' => $courseRepository->findRecent(3),
            'formations' => $formationRepository->findRecent(3),
            'posts' => $postRepository->findRecent(5),
        ]);
    }

    /**
     * @Route("/env", name="env")
     */
    public function env(): Response
    {
        return $this->render('pages/env.html.twig');
    }
}
