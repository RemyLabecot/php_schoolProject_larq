<?php
/**
 * Created by PhpStorm.
 * User: wcs
 * Date: 23/10/17
 * Time: 10:57
 * PHP version 7
 */

namespace Model;

/**
 * Class Country
 *
 */
class Country
{
    private $id;

    private $country;

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
     * @return Country
     */
    public function setId($id): Country
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     *
     * @return Country
     */
    public function setCountry($country):Country
    {
        $this->country = $country;

        return $this;
    }
}
