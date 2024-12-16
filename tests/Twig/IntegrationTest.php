<?php
namespace EndelWar\Twig\Tests;

use Twig\Test\IntegrationTestCase;

class IntegrationTest extends IntegrationTestCase
{
    public function getExtensions(): array
    {
        return array(
            new \Endelwar\Twig\ColorExtension(),
            new \Endelwar\Twig\ImageExtension(__DIR__ . '/public/', __DIR__ . '/public/cache'),
            new \Endelwar\Twig\HtmlExtension(),
        );
    }

    public static function getFixturesDirectory(): string
    {
        return __DIR__ . '/Fixtures/';
    }
}
