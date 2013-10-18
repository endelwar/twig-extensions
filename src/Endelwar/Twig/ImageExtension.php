<?php

namespace Endelwar\Twig;

/**
 * Class Twig_Extension_Image
 *
 * @package Endelwar\Twig
 * @author  Manuel Dalla Lana <endelwar@aregar.it>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/endelwar/twig-extensions
 *
 */
class ImageExtension extends Twig_Extension
{

    private $_cache_dir;

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return 'image';
    }

    /**
     * Constructor
     * Inject path to cache directory
     *
     * @param string $cache_dir cache directory
     */
    public function __construct($cache_dir)
    {
        $this->_cache_dir = $cache_dir;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'image' => new \Twig_Function_Method($this, 'image', array('is_safe' => array('html'))),
            'new_image' => new \Twig_Function_Method($this, 'newImage', array('is_safe' => array('html')))
        );
    }

    /**
     * Open a cached image
     *
     * @param string $path image path
     *
     * @return object
     */
    public function image($path)
    {
        return $this->_open($path);
    }

    /**
     * Create a new image
     *
     * @param int $width  image width
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
     * @param int    $w    image width
     * @param int    $h    imege height
     *
     * @return ImageHandler
     */
    private function _createInstance($file, $w = null, $h = null)
    {
        //$asset = $this->container->get('templating.helper.assets');
        //$full_file_path = '../../..' . $file;
        $full_file_path = substr($file, 1);
        //echo $full_file_path;

        $image = new ImageHandler($full_file_path, $w, $h);

        $image->setCacheDir($this->_cache_dir);

        $image->setFileCallback(
            function ($full_file_path) {
                $site_path = dirname($_SERVER['SCRIPT_FILENAME']);
                $relative_file_path = str_replace($site_path, '', $full_file_path);
                $relative_file_path = str_replace('/vendor/endelwar/twig-extensions/../../..', '', $relative_file_path);
                return $relative_file_path;
            }
        );

        return $image;
    }

}
