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
class ThemeManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'Theme';

    /**
     *  Initializes this class.
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct(self::TABLE, $pdo);
    }


    /**
     * @param Theme $theme
     * @return int
     */
    public function insert(Theme $theme): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`theme`) VALUES (:theme)");
        $statement->bindValue('theme', $theme->getTheme(), \PDO::PARAM_STR);

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
     * @param Theme $theme
     * @return int
     */
    public function updateTheme(Theme $theme): int
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `theme` = :theme WHERE id=:id");
        $statement->bindValue('id', $theme->getId(), \PDO::PARAM_INT);
        $statement->bindValue('theme', $theme->getTheme(), \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function updateImage(Theme $theme): int
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `image_theme` = :image WHERE id=:id");
        $statement->bindValue('id', $theme->getId(), \PDO::PARAM_INT);
        $statement->bindValue('image', $theme->getImage(), \PDO::PARAM_STR);
        return $statement->execute();
    }

    public function selectAllWithCountries()
    {
        $query = 'SELECT Tr.id as Trid, Th.id, Th.theme, Th.image_theme, Tr.theme_id 
                   FROM Theme as Th
                  JOIN Travel as Tr ON Tr.theme_id = Th.id';
        $result = $this->pdo->query($query, \PDO::FETCH_CLASS, $this->className)->fetchAll();
        return $result;
    }
}
