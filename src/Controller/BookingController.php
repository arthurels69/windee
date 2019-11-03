<?php


namespace App\Controller;

class BookingController extends AbstractController
{
    public function booking()
    {
        return $this->twig->render('Booking/booking.html.twig');
    }
}
