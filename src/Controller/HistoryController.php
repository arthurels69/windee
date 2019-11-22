<?php


namespace App\Controller;

use App\Model\BookingManager;
use App\Model\CustomerManager;

class HistoryController extends AbstractController
{

    public function login()
    {

        return $this->twig->render('History/login.html.twig');
    }

    public function index()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = htmlspecialchars(trim($_POST['email']));
//            $password = $_POST['password'];
//            $passwordHash = crypt($password, "salt");

            /*          if ($email === 'sofianesk8@hotmail.com' &&
                        $passwordHash === crypt('password', "salt")) {*/
            /*                $customerManager = new CustomerManager();
                        $customer = $customerManager->selectOneByEmail($email);*/
            $bookingManager = new BookingManager();
            $bookings = $bookingManager->selectManyByEmail($email);
            if (!empty($bookings)) {
                return $this->twig->render('History/index.html.twig', [
                    'bookings' => $bookings
                ]);
            } else {
                $error = "Désole, cette adresse e-mail n'est associée à aucune réservation";
                return $this->twig->render('History/login.html.twig', [
                    'error' => $error
                ]);
            }
        } else {
            header("location: /history/login");
        }
    }
}
