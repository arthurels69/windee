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

    public function insertTest(): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO test (`name`) VALUES (:name)");
        $statement->bindValue('name', 'Jason', \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
