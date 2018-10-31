<?php

namespace Endelwar\Twig;

/**
 * Class Twig_Extension_Image
 *
 * @package Endelwar\Twig
 * @author  Manuel Dalla Lana <endelwar@aregar.it>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/endelwar/twig-extensions
 */
class ImageExtension extends \Twig_Extension
{
    private $_cache_dir;
    private $_public_dir;

    /**
     * Constructor
     * Inject path to cache directory
     *
     * @param string $public_dir public directory
     * @param string $cache_dir cache directory
     */
    public function __construct($public_dir, $cache_dir = '')
    {
        $this->_public_dir = $public_dir;
        $this->_cache_dir = $cache_dir;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            'image' => new \Twig_SimpleFunction(
                'image',
                [$this, 'image'],
                ['is_safe' => ['html']]
            ),
            'new_image' => new \Twig_SimpleFunction(
                'new_image',
                [$this, 'newImage'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    /**
     * Open a cached image
     *
     * @param string $file the image path
     *
     * @return object
     */
    public function image($file)
    {
        return $this->_open($file);
    }

    /**
     * Create a new image
     *
     * @param int $width image width
     * @param int $height image height
     *
     * @return object
     */
    public function newImage($width, $height)
    {
        return $this->_create($width, $height);
    }

    /**
     * Get a manipulable image instance
     *
     * @param string $file the image path
     *
     * @return object a manipulable image instance
     */
    private function _open($file)
    {
        return $this->_createInstance($file);
    }

    /**
     * Get a new image
     *
     * @param int $w image width
     * @param int $h image height
     *
     * @return object a manipulable image instance
     */
    private function _create($w, $h)
    {
        return $this->_createInstance(null, $w, $h);
    }

    /**
     * Creates an instance defining the cache directory
     *
     * @param string $file file to be handled
     * @param null|int $w image width
     * @param null|int $h image height
     *
     * @return ImageHandler
     */
    private function _createInstance($file, $w = null, $h = null)
    {
        $full_file_path = $this->_public_dir . $file;
        $image = new ImageHandler($full_file_path, $w, $h);

        $image->setCacheDir($this->_cache_dir);

        $image->setFileCallback(
            function ($full_file_path) {
                return str_replace($this->_public_dir, '', $full_file_path);
            }
        );

        return $image;
    }
}
