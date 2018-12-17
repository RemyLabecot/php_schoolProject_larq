<?php
/**
 * Created by PhpStorm.
 * User: remy
 * Date: 10/10/18
 * Time: 11:06
 */

namespace Model;

class TravelManager extends AbstractManager
{
    const TABLE = 'Travel';

    /**
     *  Initializes this class.
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct(self::TABLE, $pdo);
    }

    public function insert(Travel $travel): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`title`, `price`, `duration`, `description`, 
        `theme_id`) VALUES (:title, :price, :duration, :description, :theme_id)");
        $statement->bindValue('title', $travel->getTitle(), \PDO::PARAM_STR);
        $statement->bindValue('price', $travel->getPrice(), \PDO::PARAM_INT);
        $statement->bindValue('duration', $travel->getDuration(), \PDO::PARAM_INT);
        $statement->bindValue('description', $travel->getDescription(), \PDO::PARAM_STR);
        $statement->bindValue('theme_id', $travel->getThemeid(), \PDO::PARAM_INT);

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
     * @param Travel $travel
     * @return int
     */
    public function update(Travel $travel): int
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `title` = :title, `price` = :price, 
        `duration` = :duration, `description` = :description WHERE id=:id");
        $statement->bindValue('id', $travel->getId(), \PDO::PARAM_INT);
        $statement->bindValue('title', $travel->getTitle(), \PDO::PARAM_STR);
        $statement->bindValue('price', $travel->getPrice(), \PDO::PARAM_INT);
        $statement->bindValue('duration', $travel->getDuration(), \PDO::PARAM_INT);
        $statement->bindValue('description', $travel->getDescription(), \PDO::PARAM_STR);
        return $statement->execute();
    }

    public function addDeal(int $deal, int $travel)
    {
        $statement = $this->pdo->prepare("UPDATE Travel SET `deal_id` = :deal WHERE id = :travel_id");
        $statement->bindValue('deal', $deal, \PDO::PARAM_INT);
        $statement->bindValue('travel_id', $travel, \PDO::PARAM_INT);
        return $statement->execute();
    }
    public function getDeals()
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table . ' JOIN Deal ON Deal.id = deal_id 
        WHERE `deal_id` IS NOT NULL LIMIT 3', \PDO::FETCH_CLASS, $this->className)->fetchAll();
    }
}
