<?php

namespace Endelwar\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * @author  Manuel Dalla Lana <endelwar@aregar.it>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/endelwar/twig-extensions
 */
class HtmlExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('truncate_html', [$this, 'truncate_html']),
        );
    }

    public function truncate_html($string, $length = 300, $etc = '&hellip;'): string
    {
        $i = 0;
        $tags = [];

        preg_match_all('/<[^>]+>([^<]*)/', $string, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
        foreach ($m as $o) {
            if ($o[0][1] - $i >= $length) {
                break;
            }
            $t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
            if ($t[0] !== '/') {
                $tags[] = $t;
            } elseif (end($tags) === substr($t, 1)) {
                array_pop($tags);
            }
            $i += $o[1][1] - $o[0][1];
        }

        return substr($string, 0, $length = min(strlen($string), $length + $i)) . (count(
                $tags = array_reverse($tags)
            ) ? '</' . implode(
                    '></',
                    $tags
                ) . '>' : '') . (strlen($string) > $length ? $etc : '');
    }
}
