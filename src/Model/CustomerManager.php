<?php


namespace App\Model;

class CustomerManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct('customer');
    }

    public function selectManyByEmail(string $email)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }
}
