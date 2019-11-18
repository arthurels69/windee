<?php


namespace App\Model;

class VehicleManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct('vehicle');
    }

    public function insert(array $vehicle): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table(`capacity`, `registration`, 
        `technical_control`,`price`)
        VALUES (:capacity, :registration, :technical_control, :price)");
        $statement->bindValue('capacity', $vehicle['capacity'], \PDO::PARAM_INT);
        $statement->bindValue('registration', $vehicle['registration'], \PDO::PARAM_INT);
        $statement->bindValue('technical_control', $vehicle['technical_control'], \PDO::PARAM_STR);
        $statement->bindValue('price', $vehicle['price'], \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function update(array $vehicle): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table
         SET `capacity` = :capacity, `registration` = :registration, `technical_control` = :technical_control,
         `price` = :price
         WHERE id=:id");
        $statement->bindValue('id', $vehicle['id'], \PDO::PARAM_INT);
        $statement->bindValue('capacity', $vehicle['capacity'], \PDO::PARAM_INT);
        $statement->bindValue('registration', $vehicle['registration'], \PDO::PARAM_INT);
        $statement->bindValue('technical_control', $vehicle['technical_control'], \PDO::PARAM_STR);
        $statement->bindValue('price', $vehicle['price'], \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function delete(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
