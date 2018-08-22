<?php

namespace ADesigns\CalendarBundle\Entity;


interface ColorableInterface
{
    /**
     * @param string $color
     */
    public function setColor($color);

    /**
     * @return string
     */
    public function getColor();

    /**
     * @param string $color
     */
    public function setBorderColor($color);

    /**
     * @return string
     */
    public function getBorderColor();
    
    /**
     * @param $color
     * @return $this
     */
    public function setBackgroundColor($color);

    /**
     * @return string
     */
    public function getBackgroundColor();

    /**
     * @param $color
     * @return $this
     */
    public function setTextColor($color);

    /**
     * @return string
     */
    public function getTextColor();
}