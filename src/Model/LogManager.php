<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 24/10/18
 * Time: 10:55
 */

namespace Model;

use \PDO;

class LogManager extends AbstractManager
{
    const TABLE = 'Agency';

    public function __construct(\PDO $pdo)
    {
        parent::__construct(self::TABLE, $pdo);
    }

    public function login($data)
    {
        $query = 'SELECT login,pwd FROM `Agency` WHERE
              login = :login 
              AND pwd = :pwd';
        $prepared = $this->pdo->prepare($query);
        $prepared->bindValue(':login', $data['login'], PDO::PARAM_STR);
        $prepared->bindValue(':pwd', md5($data['password']), PDO::PARAM_STR);
        $prepared->execute();
        $result = $prepared->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}
