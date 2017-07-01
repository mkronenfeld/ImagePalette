<?php

use Makro\ImagePalette\Color;
use Makro\ImagePalette\ColorMapping;

class ColorMappingTest extends \PHPUnit\Framework\TestCase {

    public function testGetNearestColor() {
        $colorMapping = new ColorMapping('colors.json');
        $colorMap = [
            'red' => [254, 1, 1],
            'yellow' => [254, 254, 1],
            'white' => [254, 254, 254],
            'cyan' => [1, 254, 254],
            'blue' => [1, 1, 254],
            'black' => [1, 1, 1],
            'lime' => [1, 254, 1],
            'magenta' => [254, 1, 254]
        ];

        foreach ($colorMap as $colorName => $colorCode) {
            $queryColor = new Color($colorCode);
            $this->assertSame(
                $colorName,
                $colorMapping->getNearestColor($queryColor)
            );
        }
    }
}
