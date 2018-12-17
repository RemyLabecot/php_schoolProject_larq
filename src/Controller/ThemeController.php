<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace Controller;

use Model\Theme;
use Model\ThemeManager;
use Service\FileHandler;
use PHP_CodeSniffer\Exceptions\TokenizerException;

/**
 * Class ThemeController
 *
 */
class ThemeController extends AbstractController
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
        $themeManager = new ThemeManager($this->getPdo());
        $themes = $themeManager->selectAll();

        return $this->twig->render('Admin/Theme/index.html.twig', ['themes' => $themes]);
    }

    /**
     * Display theme information specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function show(int $id)
    {
        $themeManager = new ThemeManager($this->getPdo());
        $theme = $themeManager->selectOneById($id);

        return $this->twig->render('Admin/Theme/show.html.twig', ['theme' => $theme]);
    }


    /**
     * Display theme edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function edit(int $id): string
    {
        $themeManager = new ThemeManager($this->getPdo());
        $theme = $themeManager->selectOneById($id);
        $errors = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->checkData($_POST);
            if (empty($errors)) {
                $theme->setTheme($_POST['theme']);
                $theme->setImage($_POST['image']);
                $themeManager->updateTheme($theme);
                $themeManager->updateImage($theme);
            }
        }

        return $this->twig->render('Admin/Theme/edit.html.twig', ['errors' => $errors, 'theme' => $theme]);
    }


    /**
     * Display theme creation page
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
                $themeManager = new ThemeManager($this->getPdo());
                $theme = new Theme();
                $theme->setTheme($_POST['theme']);
                $id = $themeManager->insert($theme);

                if (false !== $id) {
                    try {
                        $uploaded = FileHandler::upload($_FILES['files']);
                        $theme->setId($id);
                        $theme->setImage($uploaded[0]);
                        $themeManager->updateImage($theme);
                    } catch (\Exception $e) {
                        $errors[] = $e->getMessage();
                    }
                    header('Location:/admin/themes');
                }
            }
        }

        return $this->twig->render('Admin/Theme/add.html.twig', ['errors' => $errors, 'post' => $_POST]);
    }

    public function checkData($data)
    {
        $errors = [];
        if (empty($data['theme'])) {
            $errors['theme'] = "Veuillez écrire un titre";
        } else {
            $title = $this->cleanInput($data['theme']);
            if (!preg_match('/^[a-zA-Z]*$/', $title)) {
                $errors['theme'] = "Seuls les lettres et les espaces sont tolérés";
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

    /**
     * Handle Theme deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $themeManager = new ThemeManager($this->getPdo());
        $themeManager->delete($id);
        header('Location:/admin/themes');
    }
}
