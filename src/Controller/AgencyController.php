<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace Controller;

use Model\Agency;
use Model\AgencyManager;

/**
 * Class AgencyController
 *
 */
class AgencyController extends AbstractController
{


    /**
     * Display agencies listing
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        $agencyManager = new AgencyManager($this->getPdo());
        $agencies = $agencyManager->selectAll();

        return $this->twig->render('Admin/Agency/index.html.twig', ['agencies' => $agencies]);
    }

    /**
     * Display agency information specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function show(int $id)
    {
        $agencyManager = new AgencyManager($this->getPdo());
        $agency = $agencyManager->selectOneById($id);

        return $this->twig->render('Admin/Agency/show.html.twig', ['agency' => $agency]);
    }




    /**
     * Display item edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function edit(int $id): string
    {
        $agencyManager = new AgencyManager($this->getPdo());
        $agency = $agencyManager->selectOneById($id);
        $errors = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->checkData($_POST);
            if (empty($errors)) {
                $agency->setAgency($_POST['agency']);
                $agencyManager->update($agency);
            }
        }

        return $this->twig->render('Admin/Agency/edit.html.twig', ['errors' => $errors, 'agency' => $agency]);
    }


    /**
     * Display agency creation page
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function add()
    {
        $errors = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->checkData($_POST);
            if (empty($errors)) {
                $agencyManager = new AgencyManager($this->getPdo());
                $agency = new Agency();
                $agency->setAgency($_POST['agency']);
                $agency->setAddress($_POST['address']);
                $agency->setZipcode($_POST['zipcode']);
                $agency->setEmail($_POST['email']);
                $agency->setLogin($_POST['login']);
                $agency->setPwd(md5($_POST['pwd']));

                $id = $agencyManager->insert($agency);
                header('Location:/admin/agencies');
            }
        }

        return $this->twig->render('Admin/Agency/add.html.twig', ['errors' => $errors]);
    }


    /**
     * Handle country deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $agencyManager = new AgencyManager($this->getPdo());
        $agencyManager->delete($id);
        header('Location:/admin/agencies');
    }
    public function checkData($data)
    {
        $errors = [];

        if (empty($data['agency'])) {
            $errors['agency'] = "Veuillez remplir le champ";
            var_dump($errors);
        } else {
            $title = $this->cleanInput($data['agency']);
            if (!preg_match('/^[a-zA-Z]*$/', $title)) {
                $errors['agency'] = "Seuls les lettres et espaces sont tolérés";
            }
        }
        if (empty($data['zipcode'])) {
            $errors['zipcode'] = "Veuillez remplir le champ";
        } else {
            $title = $this->cleanInput($data['zipcode']);
            if (!preg_match('/[0-9]{5}/', $title)) {
                $errors['zipcode'] = "Veuillez entrer un code postal valide.";
            }
        }
        if (empty($data['login'])) {
            $errors['login'] = "Veuillez remplir le champ";
        } else {
            $title = $this->cleanInput($data['login']);
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/', $title)) {
                $errors['login'] = "Seuls les lettres et les chiffres sont tolérés";
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
}
