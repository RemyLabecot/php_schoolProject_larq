<?php
/**
 * Created by PhpStorm.
 * User: remy
 * Date: 25/10/18
 * Time: 10:06
 */

namespace Controller;

use Model\TravelManager;

class ShowTravelController extends AbstractController
{
    public function show(int $id)
    {
        $travelManager = new TravelManager($this->getPdo());
        $travels = $travelManager->selectOneById($id);

        return $this->twig->render('ShowTravel/ShowTravel.html.twig', ['travel' => $travels]);
    }
}
