<?php
/**
 * Created by PhpStorm.
 * User: remy
 * Date: 10/10/18
 * Time: 15:44
 */

namespace Model;

class Travel
{
    private $id;

    private $title;

    private $price;

    private $duration;

    private $description;

    private $themeid;

    private $dealid;
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
     * @return Travel
     */
    public function setId($id): Travel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return Travel
     */
    public function setTitle($title):Travel
    {
        $this->title = $title;

        return $this;
    }
    public function getPrice(): int
    {
        return $this->price;
    }
    public function setPrice($price): Travel
    {
        $this->price = $price;

        return $this;
    }
    public function getDuration(): int
    {
        return $this->duration;
    }
    public function setDuration($duration): Travel
    {
        $this->duration = $duration;

        return $this;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription($description): Travel
    {
        $this->description = $description;

        return $this;
    }
    public function getThemeid(): int
    {
        return $this->themeid;
    }
    public function setThemeid($themeid): Travel
    {
        $this->themeid = $themeid;

        return $this;
    }
    public function getDealid() : int
    {
        return $this->dealid;
    }
    public function setDealid($dealid)
    {
        $this->dealid = $dealid;

        return $this;
    }
}
