<?php


namespace App\Controller;

use App\Model\BookingManager;
use App\Model\StationManager;
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

    public function add()
    {
        $vehicles = new VehicleManager();
        $newvehicle = [
            'capacity' => $_POST['capacity'],
            'registration' => $_POST['registration'],
            'technical_control' => $_POST['technical_control'],
            'price' => $_POST['price']
        ];
        $vehicles->insert($newvehicle);
        header("location:/Vehicle/vehicle");
    }

    public function edit($id)
    {
        $path = 'update';
        $button = 'Editer';
        $buttonDelete = 'Supprimer';
        $vehicles = new vehicleManager();
        $vehicles = $vehicles->selectAll();
        $vehicle = new vehicleManager();
        $vehicle = $vehicle->selectOneById($id);
        return $this->twig->render("/Vehicle/vehicle.html.twig", [
            "currentvehicle" => $vehicle,
            "vehicles" => $vehicles,
            "path" => $path,
            "button" => $button,
            "buttonDelete" => $buttonDelete
        ]);
    }

    public function update($id)
    {
        $vehicles = new vehicleManager();
        $vehicle = $vehicles->selectOneById($id);
        $vehicle['capacity'] = $_POST['capacity'];
        $vehicle['registration'] = $_POST['registration'];
        $vehicle['technical_control'] = $_POST['technical_control'];
        $vehicle['price'] = $_POST['price'];
        $vehicles->update($vehicle);
        header("location:/Vehicle/vehicle");
    }

    public function delete($id)
    {
        $vehicle = new vehicleManager();
        $reservation = new BookingManager();
        $reservation = $reservation->selectAll();
        $error = "Station présente dans une réservation";
        foreach ($reservation as $booking) {
            if ($booking['id'] === $id) {
                $vehicles = new VehicleManager();
                $vehicles = $vehicles->selectAll();
                $path = 'add';
                $button = 'Ajouter';
                return $this->twig->render("Vehicle/vehicle.html.twig", [
                    'vehicles' => $vehicles,
                    'path' => $path,
                    "button" => $button,
                    "error" => $error
                ]);
            }
        }
        $vehicle = $vehicle->delete($id);
        header("location:/Vehicle/vehicle");
    }
}
