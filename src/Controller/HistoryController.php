<?php


namespace App\Controller;

class HistoryController extends AbstractController
{

    public function login()
    {
        return $this->twig->render('History/login.html.twig');
    }



    public function index()
    {

        return $this->twig->render('History/index.html.twig');
    }
}
