<?php
/**
 * Created by PhpStorm.
 * User: remy
 * Date: 10/10/18
 * Time: 11:06
 */

namespace Controller;

use Model\DealManager;
use Model\ThemeManager;
use Model\Travel;
use Model\TravelManager;

class TravelController extends AbstractController
{

    public function index()
    {
        $travelManager = new TravelManager($this->getPdo());
        $travels = $travelManager->selectAll();

        return $this->twig->render('Admin/Travel/indexAdmin.html.twig', ['travels' => $travels]);
    }

    public function show(int $id)
    {
        $travelManager = new TravelManager($this->getPdo());
        $travel = $travelManager->selectOneById($id);

        return $this->twig->render('Admin/Travel/show.html.twig', ['travel' => $travel]);
    }

    public function edit(int $id): string
    {
        $travelManager = new TravelManager($this->getPdo());
        $travel = $travelManager->selectOneById($id);
        $themeManager = new ThemeManager($this->getPdo());
        $themes = $themeManager->selectAll();
        $errors = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->checkData($_POST);
            if (empty($errors)) {
                $travel->setTitle($_POST['title']);
                $travel->setPrice($_POST['price']);
                $travel->setDuration($_POST['duration']);
                $travel->setDescription($_POST['description']);

                $travelManager->update($travel);
            }
        }

        return $this->twig->render(
            'Admin/Travel/edit.html.twig',
            ['errors'=> $errors, 'travel' => $travel, 'themes' => $themes]
        );
    }

    public function add()
    {
        $themeManager = new ThemeManager($this->getPdo());
        $themes = $themeManager->selectAll();
        $errors = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->checkData($_POST);
            if (empty($errors)) {
                $travelManager = new TravelManager($this->getPdo());
                $travel = new Travel();
                $travel->setTitle($_POST['title']);
                $travel->setPrice($_POST['price']);
                $travel->setDuration($_POST['duration']);
                $travel->setDescription($_POST['description']);
                $travel->setThemeid($_POST['themeid']);
                $id = $travelManager->insert($travel);
                header('Location:/admin');
            }
        }

        return $this->twig->render('Admin/Travel/add.html.twig', ['errors' => $errors, 'themes' => $themes]);
    }

    public function delete(int $id)
    {
        $travelManager = new TravelManager($this->getPdo());
        $travelManager->delete($id);
        header('Location:/admin/travels');
    }

    public function checkData($data)
    {
        $errors = [];
        if (empty($data['title'])) {
            $errors['title'] = "Veuillez remplir le champ";
        } else {
            $title = $this->cleanInput($data['title']);
            if (!preg_match('/^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ|[:ascii:]]*$/', $title)) {
                $errors['title'] = "Seuls les lettres et les chiffres sont tolérés";
            }
        }
        if (empty($data['price'])) {
            $errors['price'] = "Veuillez remplir le champ";
        } else {
            $title = $this->cleanInput($data['price']);
            if (!preg_match('/[0-9]{0,10}/', $title)) {
                $errors['price'] = "Veuillez entrer un nombre entre 1 et 10 chiffres.";
            }
        }
        if (empty($data['duration'])) {
            $errors['duration'] = "Veuillez remplir le champ";
        } else {
            $title = $this->cleanInput($data['duration']);
            if (!preg_match('/[0-9]{0,3}/', $title)) {
                $errors['duration'] = "Veuillez entrer un nombre entre 1 et 3 chiffres.";
            }
        }
        if (empty($data['description'])) {
            $errors['description'] = "Veuillez remplir le champ";
        } else {
            $title = $this->cleanInput($data['description']);
            if (!preg_match('/^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ|[:ascii:]]*$/', $title)) {
                $errors['description'] = "Seuls les lettres et les chiffres sont tolérés";
            }
        }
        return $errors;
    }

    private function cleanInput($variable)
    {
        $variable = trim($variable);
        $variable = stripslashes($variable);
        $variable = htmlspecialchars($variable);
        return $variable;
    }

    public function addDeal()
    {
        $travelManager = new TravelManager($this->getPdo());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $travelManager->addDeal($_POST['deal'], $_POST['travel']);
        }
        return $this->twig->render('Admin/Deal/associate.html.twig');
    }
}
