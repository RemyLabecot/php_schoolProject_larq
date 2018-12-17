<?php
/**
 * Created by PhpStorm.
 * User: luana
 * Date: 24/10/18
 * Time: 10:29
 */

namespace Model;

class DealManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'Deal';

    /**
     *  Initializes this class.
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct(self::TABLE, $pdo);
    }


    /**
     * @param Deal $deal
     * @return int
     */
    public function insert(Deal $deal): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`deal`) VALUES (:deal)");
        $statement->bindValue('deal', $deal->getDeal(), \PDO::PARAM_STR);


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
     * @param Deal $deal
     * @return int
     */
    public function update(Deal $deal):int
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `deal` = :deal WHERE id=:id");
        $statement->bindValue('id', $deal->getId(), \PDO::PARAM_INT);
        $statement->bindValue('deal', $deal->getDeal(), \PDO::PARAM_STR);


        return $statement->execute();
    }
}
