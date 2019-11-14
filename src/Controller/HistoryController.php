<?php


namespace App\Controller;

use App\Model\BookingManager;
use App\Model\CustomerManager;

class HistoryController extends AbstractController
{

    public function login()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = htmlspecialchars(trim($_POST['email']));
            $password = $_POST['password'];
            $passwordHash = crypt($password, "salt");

            if ($email === 'sofianesk8@hotmail.com' &&
                $passwordHash === crypt('password', "salt")) {
/*                $customerManager = new CustomerManager();
                $customer = $customerManager->selectOneByEmail($email);*/
                $bookingManager = new BookingManager();
                $bookings = $bookingManager->selectManyByEmail($email);
/*                var_dump($customer);
                var_dump($booking);*/

                return $this->twig->render('History/index.html.twig', [
                    'bookings' => $bookings
                ]);
            }
        }
        return $this->twig->render('History/login.html.twig');
    }

    public function index()
    {
        return $this->twig->render('History/index.html.twig');
    }
}
