<?php
/**
 * User: vtoulouse
 * Date: 22/08/2018
 * Time: 15:43
 */

namespace ADesigns\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait ColorableTrait
 * @package ADesigns\CalendarBundle\Entity
 */
trait ColorableTrait
{
    /**
     * @var string
     * @ORM\Column()
     */
    private $color;

    /**
     * @var string
     * @ORM\Column()
     */
    private $borderColor;

    /**
     * @var string
     * @ORM\Column()
     */
    private $backgroundColor;

    /**
     * @var string
     * @ORM\Column()
     */
    private $textColor;

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function getBorderColor()
    {
        return $this->borderColor;
    }

    /**
     * @param string $borderColor
     * @return $this
     */
    public function setBorderColor($borderColor)
    {
        $this->borderColor = $borderColor;
        return $this;
    }

    /**
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * @param string $backgroundColor
     * @return $this
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
        return $this;
    }

    /**
     * @return string
     */
    public function getTextColor()
    {
        return $this->textColor;
    }

    /**
     * @param string $textColor
     * @return $this
     */
    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;
        return $this;
    }
    
    
}