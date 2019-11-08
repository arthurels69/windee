<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\StationManager;

class HomeController extends AbstractController
{
    public function index()
    {
        $listeStations=new StationManager();
        $liste=$listeStations->selectAll();

        return $this->twig->render('Home/index.html.twig', ['stations'=>$liste]);
    }
}
