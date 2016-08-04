<?php

namespace Endelwar\Twig;

/**
 * Class Twig_Extension_Color
 *
 * @package Endelwar\Twig
 * @author  Manuel Dalla Lana <endelwar@aregar.it>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/endelwar/twig-extensions
 *
 */
class ColorExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return 'color';
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'ColorLuminance' => new \Twig_SimpleFunction(
                'ColorLuminance',
                array($this, 'ColorLuminance'),
                array('is_safe' => array('html'))
            ),
        );
    }

    public function ColorLuminance($hex, $lum)
    {
        // validate hex string
        $hex = preg_replace("/[^0-9a-f]/i", "", $hex);
        if (strlen($hex) < 6) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        // convert to decimal and change luminosity
        $rgb = "#";
        for ($i = 0; $i < 3; $i++) {
            $c = base_convert(substr($hex, $i * 2, 2), 16, 10);
            $c = base_convert((round(min(max(0, floatval($c + ($c * $lum))), 255))), 10, 16);
            $rgb .= substr('00' . $c, strlen($c));
        }

        return $rgb;
    }
}
