<?php


namespace App\Controller;

use App\Model\BookingManager;
use App\Model\StationManager;
use App\Model\VehicleManager;

class BookingController extends AbstractController
{

    public function booking()
    {
        $listeVehicule = new VehicleManager();
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
        $listeVehicule = new VehicleManager();
        $listeVehicule = $listeVehicule->selectAll();
        $error = 'Merci de selectionner deux stations différentes';
        if (isset($_POST['id'])) {
            $stations = $_POST['id'];
            $stations = explode('-', $stations);
            $stationD = new StationManager();
            $stationA = new StationManager();
            $stationD = $stationD->selectOneById(intval($stations[0]));
            $stationA = $stationA->selectOneById(intval($stations[1]));
        }
        if (isset($_POST['depart']) || isset($_POST['arrivee'])) {
            if (($_POST['depart']==="" || ($_POST['arrivee'])==="")) {
                $listeStations = new StationManager();
                $liste = $listeStations->selectAll();
                $error = "Merci de selectionner 2 stations";
                return $this->twig->render('Home/index.html.twig', [
                    'stations' => $liste,
                    'error' => $error
                ]);
            }
            $stationD = new StationManager();
            $stationD = $stationD->selectOneById($_POST['depart']);
            $stationA = new StationManager();
            $stationA = $stationA->selectOneById($_POST['arrivee']);
        }

        if ($stationA === $stationD) {
            $listeStations = new StationManager();
            $liste = $listeStations->selectAll();

            return $this->twig->render('Home/index.html.twig', [
                'stations' => $liste,
                'error' => $error
            ]);
        }
        $arrayStation = ['stationD' => $stationD, 'stationA' => $stationA];
        $arrayStation['vehicle'] = $listeVehicule;
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
            $error = 'Merci de selectionner deux stations différentes';
            $date = $_POST['date'];
            $hour = $_POST['hour'];
            $country = $_POST['country'];
            $nom = $_POST['lastname'];
            $prenom = $_POST['firstname'];
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user = ['dep' => $depart, 'arri' => $arrivee, 'capa' => $_POST['capacite'],
                'date' => $date, 'hour' => $hour];
            $user['email'] = $_POST['email'];
            $user['address'] = $_POST['address'];
            $user['country'] = $country;
            $user['lastname'] = $nom;
            $user['firstname'] = $prenom;
            $user['password'] = $passwordHash;
            $city = $_POST['city'];
            $vehicleManager = new VehicleManager();
            $vehicle = $vehicleManager->selectOneById((int)$_POST['capacite']);
            $stationManager = new StationManager();
            $departureStation = $stationManager->selectOneById($user['dep']);
            $arrivalStation = $stationManager->selectOneById($user['arri']);
            $booking = [
                'date' => $date,
                'hour' => $hour,
                'vehicle_id' => $vehicle['id'],
                'departure_station_id' => $departureStation['id'],
                'arrival_station_id' => $arrivalStation['id'],
            ];
            if ($depart === $arrivee) {
                $listeVehicule = new VehicleManager();
                $listeVehicule = $listeVehicule->selectAll();
                $listeStations = new StationManager();
                $listeStations = $listeStations->selectAll();
                $tabDetails = ['stations' => $listeStations, 'vehicles' => $listeVehicule];
                return $this->twig->render('Booking/booking.html.twig', [
                    'error' => $error,
                    'tabDetails' => $tabDetails,
                    'user' => $user,
                    'booking' => $booking,
                    'city' => $city
                ]);
            }
            if (empty($_POST['depart']) || empty($_POST['arrivee']) || empty($_POST['capacite'])
                || empty($_POST['date']) || empty($_POST['hour'])
                || empty($_POST['email'] || empty($_POST['adress']) || empty($_POST['country'])
                    || empty($_POST['lastname']) || empty($_POST['firstname'])
                    || empty($_POST['password']) || empty($_POST['capacite']))) {
                $error = 'Merci de remplir tous les champs';
                $listeVehicule = new VehicleManager();
                $listeVehicule = $listeVehicule->selectAll();
                $listeStations = new StationManager();
                $listeStations = $listeStations->selectAll();
                $tabDetails = ['stations' => $listeStations, 'vehicles' => $listeVehicule];
                return $this->twig->render('Booking/booking.html.twig', [
                    'error' => $error,
                    'tabDetails' => $tabDetails,
                    'user' => $user,
                    'booking' => $booking,
                    'city' => $city
                ]);
            }
            $bookingManager = new bookingManager();
            $customerId = $bookingManager->insertUser($user);
            $bookingManager->insertBooking($booking, $customerId);
            return $this->twig->render('Booking/recap.twig', [
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
            $hour = $_POST['hour'];
            $mail = $_POST['email'];
            $address = $_POST['address'];
            $country = $_POST['country'];
            $nom = $_POST['lastname'];
            $prenom = $_POST['firstname'];
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user = ['dep' => $depart, 'arri' => $arrivee, 'capa' => $capacite, 'date' => $date, 'hour' => $hour];
            $user['email'] = $mail;
            $user['address'] = $address;
            $user['country'] = $country;
            $user['lastname'] = $nom;
            $user['firstname'] = $prenom;
            $user['password'] = $passwordHash;

            $stationManager = new StationManager();
            $departureStation = $stationManager->selectOneById($user['dep']);
            $arrivalStation = $stationManager->selectOneById($user['arri']);

            $vehicle = new VehicleManager();
            $vehicle->selectOneById((int)$_POST['capacite']);

            $bookingManager = new bookingManager();
            $bookingManager->insertUser($user);
            return $this->twig->render('Booking/recap.twig', [
                'user' => $user,
                'vehicle' => $vehicle,
                'departureStation' => $departureStation['station_name'],
                'arrivalStation' => $arrivalStation['station_name']
            ]);
        }
    }
}
