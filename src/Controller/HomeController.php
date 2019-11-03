<?php

declare(strict_types=1);

namespace App\Controller;

use App\Storage\StorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function __invoke(StorageInterface $storage): Response
    {
        return $this->render('home.html.twig');
    }
}
