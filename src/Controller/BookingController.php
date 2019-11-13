<?php


namespace App\Controller;

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

        $tabDetails = ['stations' => $listeStations, 'vehicule' => $listeVehicule];

        return $this->twig->render('Booking/booking.html.twig', ['tabDetails' => $tabDetails]);
    }

    public function bookingRempli()
    {
        $stationD = "";
        $stationA = "";
        $depart = "";
        $arrivee = "";
        $listeVehicule = new VehicleManager();
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

    public function recapitulatif()
    {
        $depart = $_POST['depart'];
        $arrivee = $_POST['arrivee'];
        $capacite = $_POST['capacite'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $mail = $_POST['mail'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];

        $array = ['dep' => $depart, 'arri' => $arrivee, 'capa' => $capacite, 'date' => $date, 'heure' => $heure];
        $array['mail']=$mail;
        $array['nom'] = $nom;
        $array['prenom'] = $prenom;

        return $this->twig->render('Booking/recapitulatif.html.twig', ['arrayRecap' => $array]);
    }

    public function final()
    {
        return $this->twig->render('Booking/final.html.twig');
    }
}
