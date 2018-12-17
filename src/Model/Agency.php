<?php


namespace Model;

class Agency
{
    private $id;

    private $agency;

    private $address;

    private $zipcode;

    private $email;

    private $login;

    private $pwd;


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
     * @return Agency
     */
    public function setId($id): Agency
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgency(): ?string
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     *
     * @return Agency
     */
    public function setAgency($agency): Agency
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     *
     * @return Agency
     */
    public function setAddress($address): Agency
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return int
     */
    public function getZipcode(): int
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     *
     * @return Agency
     */
    public function setZipcode($zipcode): Agency
    {
        $this->zipcode = $zipcode;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return Agency
     */
    public function setEmail($email): Agency
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     *
     * @return Agency
     */
    public function setLogin($login): Agency
    {
        $this->login = $login;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getPwd(): string
    {
        return $this->pwd;
    }

    /**
     * @param mixed $pwd
     *
     * @return Agency
     */
    public function setPwd($pwd): Agency
    {
        $this->pwd = $pwd;

        return $this;
    }
}
