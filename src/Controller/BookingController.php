<?php


namespace App\Controller;

use App\Model\BookingManager;
use App\Model\StationManager;
use App\Model\VehiculeManager;

class BookingController extends AbstractController
{

    public function booking()
    {
        $listeVehicule = new VehiculeManager();
        $listeVehicule = $listeVehicule->selectAll();

        $listeStations = new StationManager();
        $listeStations = $listeStations->selectAll();

        $tabDetails = ['stations' => $listeStations, 'vehicles' => $listeVehicule];

        return $this->twig->render('Booking/booking.html.twig', ['tabDetails' => $tabDetails]);
    }

    public function bookingRempli()
    {
        $stationD = "";
        $stationA = "";
        $depart = "";
        $arrivee = "";
        $listeVehicule = new VehiculeManager();
        $listeVehicule = $listeVehicule->selectAll();
        if (isset($_POST['id'])) {
            $stations = $_POST['id'];
            $stations = explode('-', $stations);
            $stationD = new StationManager();
            $stationA = new StationManager();
            $stationD = $stationD->selectOneById(intval($stations[0]));
            $stationA = $stationA->selectOneById(intval($stations[1]));
        }
        if (isset($_POST['depart'])) {
            $depart = $_POST ['depart'];
        }
        if (isset($_POST['depart'])) {
            $arrivee = $_POST['arrivee'];
        }

        $arrayStation = ['stationD' => $stationD, 'stationA' => $stationA, 'depart' => $depart, 'arrivee' => $arrivee];
        $arrayStation['vehicule'] = $listeVehicule;

        return $this->twig->render('Booking/bookingRempli.html.twig', ['arrayStation' => $arrayStation]);
    }

    public function final()
    {
        return $this->twig->render('Booking/final.html.twig');
    }

    public function recap()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $depart = (int)$_POST['depart'];
            $arrivee = (int)$_POST['arrivee'];
            $vehicle = (int)$_POST['capacite'];
            $date = $_POST['date'];
            $heure = $_POST['heure'];
            $mail = $_POST['email'];
            $address = $_POST['address'];
            $country = $_POST['country'];
            $nom = $_POST['lastname'];
            $prenom = $_POST['firstname'];
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user = ['dep' => $depart, 'arri' => $arrivee, 'capa' => $vehicle, 'date' => $date, 'heure' => $heure];
            $user['email']=$mail;
            $user['address']=$address;
            $user['country']=$country;
            $user['lastname'] = $nom;
            $user['firstname'] = $prenom;
            $user['password'] = $passwordHash;
            $vehicleManager = new VehiculeManager();
            $vehicle = $vehicleManager->selectOneById((int)$_POST['capacite']);

            $stationManager = new StationManager();
            $departureStation = $stationManager->selectOneById($user['dep']);
            $arrivalStation = $stationManager->selectOneById($user['arri']);

            $booking = [
                'date' => $date,
                'vehicle_id' => $vehicle['id'],
                'departure_station_id' => $departureStation['id'],
                'arrival_station_id' => $arrivalStation['id'],
            ];

            $bookingManager = new bookingManager();
            $customerId = $bookingManager->insertUser($user);

            $bookingManager->insertBooking($booking, $customerId);

            return $this->twig->render('Booking/recapitulatif.html.twig', [
                'user' => $user,
                'vehicle' => $vehicle,
                'departureStation' => $departureStation['station_name'],
                'arrivalStation' => $arrivalStation['station_name']
            ]);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $depart = (int)$_POST['depart'];
            $arrivee = (int)$_POST['arrivee'];
            $capacite = $_POST['capacite'];
            $date = $_POST['date'];
            $heure = $_POST['heure'];
            $mail = $_POST['email'];
            $address = $_POST['address'];
            $country = $_POST['country'];
            $nom = $_POST['lastname'];
            $prenom = $_POST['firstname'];
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user = ['dep' => $depart, 'arri' => $arrivee, 'capa' => $capacite, 'date' => $date, 'heure' => $heure];
            $user['email']=$mail;
            $user['address']=$address;
            $user['country']=$country;
            $user['lastname'] = $nom;
            $user['firstname'] = $prenom;
            $user['password'] = $passwordHash;

            $stationManager = new StationManager();
            $departureStation = $stationManager->selectOneById($user['dep']);
            $arrivalStation = $stationManager->selectOneById($user['arri']);

            $vehicle = new VehiculeManager();
            $vehicle->selectOneById((int)$_POST['capacite']);

            $bookingManager = new bookingManager();
            $bookingManager->insertUser($user);
            return $this->twig->render('Booking/recapitulatif.html.twig', [
                'user' => $user,
                'vehicle' => $vehicle,
                'departureStation' => $departureStation['station_name'],
                'arrivalStation' => $arrivalStation['station_name']
            ]);
        }
    }
}
