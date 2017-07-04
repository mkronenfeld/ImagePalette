# ImagePalette

ImagePalette is used to extract a color palette from a given image. Aside from being a native PHP implementation, ImagePalette differs from many palette extractors as it works off a white list color palette. Below is the default palette:

![](http://i.imgur.com/Rabqkqq.png)

The main advantage of working from a color palette is closer matching, as each pixel simply has to calculate the color-distance within the palette and chose the best match. This is useful for working with color taxonomies as the taxonomy should have a finite amount of colors.

![](http://i.imgur.com/O8fsFWz.png)

See an example of this in action here: http://alpha.wallhaven.cc/wallpaper/21852

## Requirements
```PHP >= 5.4``` ```php5-gd```

## Installation

Simply add the following to your ```composer.json``` file:

```JSON
"require": {
    "mkronenfeld/image-palette": "dev-master"
}
```

## Usage

```PHP
// initiate with image
$palette = new \Makro\ImagePalette\ImagePalette( 'https://www.google.co.uk/images/srpr/logo3w.png' );

// get the prominent colors
$colors = $palette->colors; // array of Color objects

// to string as json
echo $palette; // '["#ffffdd", ... ]'

// implements IteratorAggregate
foreach ($palette as $color) {
  // Color provides several getters/properties
  echo $color;             // '#ffffdd'
  echo $color->rgbString;  // 'rgb(255,255,221)'
  echo $color->rgbaString; // 'rgba(255,255,221,0.25)'
  echo $color->int;        // 0xffffdd
  echo $color->rgb;        // array(255,255,221)
  echo $color->rgba;       // array(255,255,221,0.25)
}
```

```PHP
// initiate color mapping
$mapping = new \Makro\ImagePalette\ColorMapping();

// get the name of the nearest color 
echo $mapping->getNearestColor($color);
```

And there we go!

### Options

#### Precision

By default, `ImagePalette` will process every 10th pixel. This is for performance reasons, you can change this like below. The precision is a performance-to-time decision.

```PHP
$palette = new \Makro\ImagePalette\ImagePalette( $src, 5 /* precision */ );
```

#### Color Count

To control the amount colors returned set the third parameter.
You can also provide the getter with a custom length.

```PHP
$palette = new \Makro\ImagePalette\ImagePalette( $src, 5, 3 /* number of colors to return */ );
$colors  = $palette->getColors( 7 /* number of colors to return */ );
```

#### Custom color mapping

By default, `ColorMapping` will map the provided colors according to the colors.json in this package.
You can use a custom colors.json by setting the path to your color file as the first parameter.

```PHP
new \Makro\ImagePalette\ColorMapping( '/path/to/your/colors.json' );
```

## Contribution guidelines ##

See: https://github.com/brianmcdo/ImagePalette/blob/master/CONTRIBUTING.md
