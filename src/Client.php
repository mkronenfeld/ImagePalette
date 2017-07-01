<?php

namespace Makro\ImagePalette;

/**
 * Class Client
 *
 * @package Makro\ImagePalette
 */
class Client
{
    /**
     * Get most prominent colors as array
     * of Makro\ImagePalette\Color
     * 
     * @param mixed  $fileOrUrl
     * @param int    $precision
     * @param int    $maxNumColors
     * @param string $overrideExt
     * @return array
     */
    public function getColors($fileOrUrl, $precision = 10, $maxNumColors = 5, $overrideExt = 'gd')
    {
        $load = new ImagePalette($fileOrUrl, $precision, $maxNumColors, $overrideExt);
        return $load->getColors();
    }
} 
