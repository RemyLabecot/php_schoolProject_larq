<?php
/**
 * Created by PhpStorm.
 * User: luana
 * Date: 17/10/18
 * Time: 15:44
 */

namespace Controller;

use Model\AgencyManager;
use Model\ThemeManager;
use Model\TravelManager;
use Twig_Loader_Filesystem;
use Twig_Environment;

class HomepageController extends AbstractController
{
    public function home()
    {
        $themeManager = new ThemeManager($this->getPdo());
        $themes = $themeManager->selectAllwithCountries();
        $agencyManager = new AgencyManager($this->getPdo());
        $agencies = $agencyManager->selectAll();
        $travelManager = new TravelManager($this->getPdo());
        $travels = $travelManager->getDeals();

        return $this->twig->render('Homepage/Homepage.html.twig', ['themes' => $themes, 'agencies'=> $agencies,
            'deals' => $travels]);
    }
}
