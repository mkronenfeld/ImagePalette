<?php

namespace Makro\ImagePalette;

/**
 * Validates the environment (PHP settings, extensions, etc.)
 *
 * @package Makro\ImagePalette
 */
class Validator
{
    /**
     * The validation protocol.
     *
     * @access protected
     * @var    array $version
     */
    protected $protocol = [ ];

    /**
     * Human readable protocol translations.
     *
     * @access private
     * @var    array
     */
    protected $protocolErrorTranslations = [
        'allow_url_fopen'                      => 'Your php.ini does not allow this app to access URL object like image files.',
        'image_manipulation_library_available' => 'There is no PHP image manipulation library (gd or imagick) available on your server.'
    ];

    /**
     * Checks several php extensions are available.
     *
     * @return void
     */
    protected function checkExtensions()
    {
        $extensions                                             = [ 'gd', 'imagick' ];
        $this->protocol['extensions']                           = [ ];
        $this->protocol['image_manipulation_library_available'] = false;

        foreach ($extensions as $extension) {
            $extensionLoaded = extension_loaded( $extension );

            $this->protocol['extensions']['extension_loaded_' . $extension] = $extensionLoaded;

            if ($extensionLoaded) {
                $this->protocol['image_manipulation_library_available'] = true;
            }
        }
    }

    /**
     * Checks the php ini.
     *
     * @return void
     */
    protected function checkFilesystemConfigurationOptions()
    {
        $this->protocol['allow_url_fopen'] = ini_get( 'allow_url_fopen' );
    }

    /**
     * Converts the protocol into a human-readable to-do list.
     *
     * @return array
     */
    public function getProtocolErrors()
    {
        $translation = [ ];

        foreach ($this->protocol as $key => $entry) {
            if (false === $entry && isset($this->protocolErrorTranslations[$key])) {
                $translation[$key] = $this->protocolErrorTranslations[$key];
            }
        }

        return $translation;
    }

    /**
     * Creates the validation protocol.
     *
     * @return array
     */
    protected function run()
    {
        $this->protocol = [ ];

        $this->checkExtensions();
        $this->checkFilesystemConfigurationOptions();

        return $this->protocol;
    }

    /**
     * Validates the system settings.
     *
     * @return array
     */
    public function validate()
    {
        if (empty( $this->protocol )) {
            $this->run();
        }

        $response             = [ ];
        $response['success']  = ! in_array( false, $this->protocol );
        $response['errors']   = $this->getProtocolErrors();
        $response['protocol'] = $this->protocol;

        return $response;
    }
}
