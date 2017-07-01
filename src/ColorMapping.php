<?php

namespace Makro\ImagePalette;

use Makro\ImagePalette\Color;

/**
 * Assigns colors to the color map.
 *
 * @author Marvin Kronenfeld
 * @package Makro\ImagePalette
 */
class ColorMapping
{
    /**
     * Path to the color map.
     * @var string
     */
    const COLOR_FILE = 'colors.json';

    /**
     * The default colors.
     * @var array
     */
    private $colorMap = null;

    /**
     * Initializes ColorMapping.
     *
     * @param string $path Path to the color file.
     */
    public function __construct($path = null)
    {
        $this->setColorMap($path);
    }

    /**
     * Gets the color map.
     *
     * @return array
     */
    private function getColorMap()
    {
        return $this->colorMap;
    }

    /**
     * Gets the distance between two positions.
     *
     * d² = (x - qx)² + (y - qy)² + (z - qz)²
     *
     * @return integer
     */
    private function getDistance($pos_a, $pos_b)
    {
        $a = pow($pos_a->r - $pos_b->r, 2);
        $b = pow($pos_a->g - $pos_b->g, 2);
        $c = pow($pos_a->b - $pos_b->b, 2);

        return sqrt($a + $b + $c);
    }

    /**
     * Gets the nearest color.
     *
     * @param array $queryColor The queried color.
     *
     * @return string
     */
    public function getNearestColor($queryColor)
    {
        $colorMap = $this->getColorMap();
        $distanceMap = [];

        foreach ($colorMap as $colorMapping) {
            $color = new Color($colorMapping->code);
            $distanceMap[$colorMapping->name] = $this->getDistance(
                $queryColor,
                $color
            );
        }

        asort($distanceMap);
        reset($distanceMap);

        return key($distanceMap);
    }

    /**
     * Sets the color map.
     *
     * @param string $path Path to the color file.
     *
     * @return ColorMapping
     */
    private function setColorMap($path = null)
    {
        if (empty($path)) {
            $path = self::COLOR_FILE;
        }

        $contents = file_get_contents($path);
        $contents = utf8_encode($contents);

        $this->colorMap = json_decode($contents);

        return $this;
    }
}
