<?php


namespace App\Model;

class BookingManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct('booking');
    }

    public function insertUser(array $user): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO `customer` (`firstname`, `lastname`, `address`, 
`country`, `email`, `password`) VALUES (:firstname, :lastname, :address, :country, :email, :password)");
        $statement->bindValue('firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('address', $user['address'], \PDO::PARAM_STR);
        $statement->bindValue('country', $user['country'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function insertBooking(array $booking, $customerId): int
    {
        // prepared request
        $statement = $this->pdo->prepare("
            INSERT INTO `booking` (`date`, `vehicle_id`, `departure_station_id`, `arrival_station_id`, `customer_id`)
            VALUES (:date, :vehicle_id, :departure_station_id, :arrival_station_id, :customer_id)
            ");
        $statement->bindValue('date', $booking['date'], \PDO::PARAM_STR);
        $statement->bindValue('vehicle_id', $booking['vehicle_id'], \PDO::PARAM_INT);
        $statement->bindValue('departure_station_id', $booking['departure_station_id'], \PDO::PARAM_INT);
        $statement->bindValue('arrival_station_id', $booking['arrival_station_id'], \PDO::PARAM_INT);
        $statement->bindValue('customer_id', $customerId, \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
