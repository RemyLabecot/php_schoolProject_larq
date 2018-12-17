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
 * Class Theme
 *
 */
class Theme
{
    private $id;

    private $theme;

    private $image;

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
     * @return Theme
     */
    public function setId($id): Theme
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     *
     * @return Theme
     */
    public function setTheme($theme):Theme
    {
        $this->theme = $theme;

        return $this;
    }
    public function getImage():string
    {
        return $this->image;
    }
    public function setImage($image):Theme
    {
        $this->image = $image;

        return $this;
    }
}
