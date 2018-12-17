<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace Controller;

use Model\Country;
use Model\CountryManager;

/**
 * Class CountryController
 *
 */
class CountryController extends AbstractController
{


    /**
     * Display countries listing
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        $countryManager = new CountryManager($this->getPdo());
        $countries = $countryManager->selectAll();

        return $this->twig->render('Admin/Country/index.html.twig', ['countries' => $countries]);
    }


    /**
     * Display country information specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function show(int $id)
    {
        $countryManager = new CountryManager($this->getPdo());
        $country = $countryManager->selectOneById($id);

        return $this->twig->render('Admin/Country/show.html.twig', ['country' => $country]);
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
        $countryManager = new CountryManager($this->getPdo());
        $country = $countryManager->selectOneById($id);
        $errors = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->checkData($_POST);
            if (empty($errors)) {
                $country->setCountry($_POST['country']);
                $countryManager->update($country);
            }
        }

        return $this->twig->render('Admin/Country/edit.html.twig', ['errors' => $errors, 'country' => $country]);
    }


    /**
     * Display country creation page
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
                $countryManager = new CountryManager($this->getPdo());
                $country = new Country();
                $country->setCountry($_POST['country']);
                $id = $countryManager->insert($country);
                header('Location:/admin/countries');
            }
        }

        return $this->twig->render('Admin/Country/add.html.twig', ['errors' => $errors]);
    }


    /**
     * Handle country deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $countryManager = new CountryManager($this->getPdo());
        $countryManager->delete($id);
        header('Location:/admin/countries');
    }

    public function checkData($data)
    {
        $errors = [];
        if (empty($data['country'])) {
            $errors['country'] = "Veuillez remplir le champ";
        } else {
            $title = $this->cleanInput($data['country']);
            if (!preg_match('/^[a-zA-Z]*$/', $title)) {
                $errors['country'] = "Seuls les lettres et espaces sont tolérés";
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
