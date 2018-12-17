<?php
/**
 * Created by PhpStorm.
 * User: luana
 * Date: 24/10/18
 * Time: 10:40
 */

namespace Controller;

use Model\Deal;
use Model\DealManager;
use Model\TravelManager;

class DealController extends AbstractController
{
    /**
     * Display deals listing
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        $dealManager = new DealManager($this->getPdo());
        $deals = $dealManager->selectAll();

        return $this->twig->render('Admin/Deal/index.html.twig', ['deals' => $deals]);
    }


    /**
     * Display deal information specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function show(int $id)
    {
        $dealManager = new DealManager($this->getPdo());
        $deal = $dealManager->selectOneById($id);

        return $this->twig->render('Admin/Deal/show.html.twig', ['deal' => $deal]);
    }


    /**
     * Display deal edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function edit(int $id): string
    {
        $dealManager = new DealManager($this->getPdo());
        $deal = $dealManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $deal->setDeal($_POST['deal']);
            $dealManager->update($deal);
        }

        return $this->twig->render('Admin/Deal/edit.html.twig', ['deal' => $deal]);
    }


    /**
     * Display deal creation page
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dealManager = new DealManager($this->getPdo());
            $deal = new Deal();
            $deal->setDeal($_POST['deal']);
            $id = $dealManager->insert($deal);
            header('Location:/admin/deal/' . $id);
        }

        return $this->twig->render('Admin/Deal/add.html.twig');
    }

    /**
     * Handle deal deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $dealManager = new DealManager($this->getPdo());
        $dealManager->delete($id);
        header('Location:/admin/deals');
    }

    public function associate()
    {
        $dealManager = new DealManager($this->getPdo());
        $deals = $dealManager->selectAll();

        $travelManager = new TravelManager($this->getPdo());
        $travels = $travelManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $travelManager->addDeal($_POST['travel'], $_POST['deal']);
            header('Location:/admin/travels');
        }

        return $this->twig->render('Admin/Deal/associate.html.twig', ['deals' => $deals, 'travels' => $travels]);
    }
}
