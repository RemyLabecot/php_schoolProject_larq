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
class AgencyManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'Agency';

    /**
     *  Initializes this class.
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct(self::TABLE, $pdo);
    }


    /**
     * @param Agency $agency
     * @return int
     */
    public function insert(Agency $agency): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`agency`, `address`, `zipcode`, `email`, 
`login`, `pwd`) VALUES (:agency, :address, :zipcode, :email, :login, :pwd)");
        $statement->bindValue('agency', $agency->getAgency(), \PDO::PARAM_STR);
        $statement->bindValue('address', $agency->getAddress(), \PDO::PARAM_STR);
        $statement->bindValue('zipcode', $agency->getZipcode(), \PDO::PARAM_INT);
        $statement->bindValue('email', $agency->getEmail(), \PDO::PARAM_STR);
        $statement->bindValue('login', $agency->getLogin(), \PDO::PARAM_STR);
        $statement->bindValue('pwd', $agency->getPwd(), \PDO::PARAM_STR);


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
     * @param Agency $agency
     * @return int
     */
    public function update(Agency $agency): int
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `agency` = :agency WHERE id=:id");
        $statement->bindValue('id', $agency->getId(), \PDO::PARAM_INT);
        $statement->bindValue('agency', $agency->getAgency(), \PDO::PARAM_STR);


        return $statement->execute();
    }
}
