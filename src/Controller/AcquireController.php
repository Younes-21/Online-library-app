<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcquireController extends AbstractController
{
    /**
     * @Route("/acquire", name="acquire")
     */
    public function index(): Response
    {
        return $this->render('acquire/index.html.twig', [
            'controller_name' => 'AcquireController',
        ]);
    }
}
