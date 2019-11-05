<?php


namespace App\Controller;

use App\Model\StationManager;

class BookingController extends AbstractController
{
    public function booking()
    {
        $listeStations = new StationManager();
        $liste = $listeStations->selectAll();

        return $this->twig->render('Booking/booking.html.twig', ['stations' => $liste]);
    }

    public function bookingRempli()
    {
        $stationD = "";
        $stationA = "";
        $depart = "";
        $arrivee = "";
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
        $arrayStation=['stationD' => $stationD, 'stationA' => $stationA, 'depart' => $depart, 'arrivee' => $arrivee];
        return $this->twig->render('Booking/bookingRempli.html.twig', ['arrayStation'=>$arrayStation]);
    }
}
