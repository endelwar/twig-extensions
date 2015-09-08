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
 *
 */
class ImageHandler extends Image
{
    protected $fileCallback = null;

    /**
     * Defines the callback to call to compute the new filename
     */
    public function setFileCallback($file)
    {
        $this->fileCallback = $file;
    }

    /**
     * When processing the filename, call the callback
     */
    protected function getFilename($filename)
    {
        $callback = $this->fileCallback;

        if (null === $callback) {
            return $filename;
        }

        return $callback($filename);
    }
}
