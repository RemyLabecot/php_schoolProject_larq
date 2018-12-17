<?php
/**
 * Created by PhpStorm.
 * User: luana
 * Date: 24/10/18
 * Time: 10:26
 */

namespace Model;

class Deal
{
    private $id;

    private $deal;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Deal
     */
    public function setId($id): Deal
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeal(): int
    {
        return $this->deal;
    }

    /**
     * @param mixed $deal
     *
     * @return Deal
     */
    public function setDeal($deal):Deal
    {
        $this->deal = $deal;

        return $this;
    }
}
