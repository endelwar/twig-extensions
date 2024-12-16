<?php

namespace Endelwar\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class Twig_Extension_Image
 *
 * @package Endelwar\Twig
 * @author  Manuel Dalla Lana <endelwar@aregar.it>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/endelwar/twig-extensions
 */
class ImageExtension extends AbstractExtension
{
    private string $_cache_dir;
    private string $_public_dir;

    /**
     * Constructor
     * Inject path to cache directory
     *
     * @param string $public_dir public directory
     * @param string $cache_dir cache directory
     */
    public function __construct(string $public_dir, string $cache_dir = '')
    {
        $this->_public_dir = $public_dir;
        $this->_cache_dir = $cache_dir;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            'image' => new TwigFunction(
                'image',
                [$this, 'image'],
                ['is_safe' => ['html']]
            ),
            'new_image' => new TwigFunction(
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
    public function image(string $file)
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
    public function newImage(int $width, int $height)
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
    private function _open(string $file)
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
     * @param int|null $w image width
     * @param int|null $h image height
     *
     * @return ImageHandler
     */
    private function _createInstance($file, ?int $w = null, ?int $h = null)
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
