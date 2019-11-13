<?php


namespace App\Controller;

use App\Model\VehicleManager;

class VehicleController extends AbstractController
{
    public function vehicle()
    {
        if (!isset($_SESSION['user'])) {
            header('location: /back/login');
        }
        $vehicles = new VehicleManager();
        $vehicles = $vehicles->selectAll();
        $path = 'add';
        $button = 'Ajouter';
        return $this->twig->render('Vehicle/vehicle.html.twig', [
            'vehicles' => $vehicles,
            'path' => $path,
            "button" => $button
        ]);
    }
}
