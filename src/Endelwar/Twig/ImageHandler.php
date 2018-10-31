<?php

namespace Endelwar\Twig;

use Gregwar\Image\Image;

/**
 * Class ImageHandler
 *
 * @package Endelwar\Image
 * @author  Manuel Dalla Lana <endelwar@aregar.it>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/endelwar/twig-extensions
 */
class ImageHandler extends Image
{
    /**
     * @var callable
     */
    protected $fileCallback;

    /**
     * Defines the callback to call to compute the new filename
     *
     * @param callable $file
     */
    public function setFileCallback($file)
    {
        $this->fileCallback = $file;
    }

    /**
     * @return callable
     */
    public function getFileCallback()
    {
        return $this->fileCallback;
    }

    /**
     * When processing the filename, call the callback
     * @param string $filename
     * @return string
     */
    protected function getFilename($filename)
    {
        $callback = $this->getFileCallback();

        if (is_callable($callback)) {
            return $callback($filename);
        }

        return $filename;
    }
}
