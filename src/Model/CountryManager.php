<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace Model;

/**
 *
 */
class CountryManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'Country';

    /**
     *  Initializes this class.
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct(self::TABLE, $pdo);
    }


    /**
     * @param Country $country
     * @return int
     */
    public function insert(Country $country): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`country`) VALUES (:country)");
        $statement->bindValue('country', $country->getCountry(), \PDO::PARAM_STR);


        if ($statement->execute()) {
            return $this->pdo->lastInsertId();
        }
    }


    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    /**
     * @param Country $country
     * @return int
     */
    public function update(Country $country):int
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `country` = :country WHERE id=:id");
        $statement->bindValue('id', $country->getId(), \PDO::PARAM_INT);
        $statement->bindValue('country', $country->getCountry(), \PDO::PARAM_STR);


        return $statement->execute();
    }
}
