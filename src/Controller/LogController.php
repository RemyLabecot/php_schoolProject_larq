<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 24/10/18
 * Time: 10:52
 */

namespace Controller;

use Model\LogManager;
use \Exception;

class LogController extends AbstractController
{

    public function login()
    {
        $errors = null;
        $logManager = new LogManager($this->getPdo());
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            try {
                $logManager->login($_POST);
                if (null == $logManager->login($_POST)) {
                    throw new Exception('Votre identifiant ou votre mot de passe est incorrect !');
                }
                $_SESSION['login'] = $_POST['login'];
                header('Location:/admin');
            } catch (Exception $e) {
                $errors = $e->getMessage();
            }
        }
        return $this->twig->render('login.html.twig', ['errors' => $errors]);
    }

    public function logout()
    {
        unset($_SESSION['login']);
        header('Location:/');
        exit();
    }
}
