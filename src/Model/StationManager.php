<?php


namespace App\Model;

class StationManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct('station');
    }

    public function insert(array $station): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table(`station_name`, `street_name`, 
        `number`,`zipcode`, `city`)
        VALUES (:station_name, :street_name, :number, :zipcode, :city)");
        $statement->bindValue('station_name', $station['station_name'], \PDO::PARAM_STR);
        $statement->bindValue('street_name', $station['street_name'], \PDO::PARAM_STR);
        $statement->bindValue('number', $station['number'], \PDO::PARAM_INT);
        $statement->bindValue('zipcode', $station['zipcode'], \PDO::PARAM_INT);
        $statement->bindValue('city', $station['city'], \PDO::PARAM_STR);
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

    public function update(array $station): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table
         SET `station_name` = :station_name, `street_name` = :street_name, `number` = :number,
         `zipcode` = :zipcode,  `city` = :city
         WHERE id=:id");
        $statement->bindValue('id', $station['id'], \PDO::PARAM_INT);
        $statement->bindValue('station_name', $station['station_name'], \PDO::PARAM_STR);
        $statement->bindValue('street_name', $station['street_name'], \PDO::PARAM_STR);
        $statement->bindValue('number', $station['number'], \PDO::PARAM_INT);
        $statement->bindValue('zipcode', $station['zipcode'], \PDO::PARAM_INT);
        $statement->bindValue('city', $station['city'], \PDO::PARAM_STR);
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
