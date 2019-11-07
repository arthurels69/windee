<?php


namespace App\Controller;

class ConceptController extends AbstractController
{
    public function index()
    {
        return $this->twig->render('Concept/index.html.twig');
    }
}
